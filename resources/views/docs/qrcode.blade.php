<div style="border: 2px solid black; display: inline-block; border-radius: 5px; padding: 10px;">
    <img src="data:image/png;base64, {!! base64_encode(
    QrCode::format('png')->size(120)->style('round')->generate(route('certificates', $documentData['serviceHash'])),
) !!} ">
    <div style="display: inline-block; vertical-align:middle; text-align: left; margin-left: 10px;">
        <h5 style="line-height: 30px;">Bióloga Responsável: <br/> Cintia F. Petrelli dos Santos <br/> CRBio - 61204/01D</h5>
        <p style="padding: 0; margin-top: -7px;">Assinado Eletronicamente</p>
    </div>
</div>
