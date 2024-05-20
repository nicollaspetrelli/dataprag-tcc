<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clients';
    protected $dates = ['deleted_at'];

    public const INDIVIDUAL = 1;
    public const LEGAL = 0;

    protected $casts = [
        'fantasyName' => 'string',
        'companyName' => 'string',
        'identificationName' => 'string',
        'documentNumber' => 'string',
        'street' => 'string',
        'neighborhood' => 'string',
        'number' => 'string',
        'zipcode' => 'string',
        'city' => 'string',
        'state' => 'string',
        'referencePoint' => 'string',
        'complement' => 'string',
        'type' => 'integer',
        'notes' => 'string',
        'respName' => 'string',
        'respPhone' => 'string',
        'respEmail' => 'string',
        'respNotes' => 'string',
    ];

    protected $fillable = [
        'fantasyName',
        'companyName',
        'identificationName',
        'documentNumber',
        'street',
        'neighborhood',
        'number',
        'zipcode',
        'city',
        'state',
        'referencePoint',
        'complement',
        'type',
        'notes',
        'respName',
        'respPhone',
        'respEmail',
        'respNotes',
    ];

    public function service()
    {
        return $this->hasMany(Service::class);
    }

    public function lastService()
    {
        return $this->hasMany(Service::class)->latest();
    }

    public function lastServiceTime(Collection $lastService): string
    {
        if ($lastService->count() > 0) {
            return $lastService->first()->created_at->format('d/m/Y H:i');
        }

        return $this->created_at->format('d/m/Y H:i');
    }

    /**
     * Verifica se o ultimo serviço do cliente está vencido
     *
     * @param Cliente $id
     * @return void
     */
    public function isOverdue()
    {
        $client = Clients::findOrFail($this->id);

        $service = new Service();
        $validityDates = $service->select('dateValidity')->where('clients_id', $client->id)->where('dateValidity', '>=', Carbon::now())->orderBy('id', 'desc')->get();

        if (!isset($validityDates[0])) {
            return null;
        }

        return $validityDates[0]->dateValidity->format('d/m/Y');
    }

    public static function getClientType($type)
    {
        return $type == Clients::LEGAL ? $type : Clients::INDIVIDUAL;
    }

    public function getLastInsertedService()
    {
        $service = new Service();
        $lastService = $service->select('id', 'dateValidity')->where('clients_id', $this->id)->orderBy('dateValidity', 'desc')->get();

        return $lastService[0]->id ?? 0;
    }

    public function getAllLastInsertedService(): array
    {
        $service = new Service();
        $documents = Document::all();

        $lastServices = [];

        // foreach a colletion
        foreach ($documents as $document) {
            $services = $service->select('id', 'dateValidity')->where('clients_id', $this->id)->where('documents_id', $document->id)->orderBy('dateValidity', 'desc')->get();
            $lastServices[$document->name] = $services[0]->id ?? null;
        }

        return $lastServices;
    }

    public function getNonExpiredServices(): array
    {
        $service = new Service();

        return $service->select('id', 'documents_id', 'clients_id', 'dateValidity')->where('clients_id', $this->id)->where('expired', '!=', 2)->orderBy('dateValidity', 'desc')->get()->toArray();
    }
}
