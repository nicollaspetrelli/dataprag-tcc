<table class="table table-bordered mb-4">
    <thead>
        <tr>
            <th>Defensivos</th>
            <th>Grupo Químico</th>
            <th>Princípio Ativo</th>
            <th>Registro na DISAD do <br/> ministério da saúde</th>
            <th>Classe toxicológica</th>
        </tr>
    </thead>
    <tbody>
        @foreach ( $documentData['products'] as $product)
        <tr>
            <td>{{ $product['defensive'] ?? '-' }}</td>
            <td>{{ $product['chemical'] ?? '-' }}</td>
            <td>{{ $product['active'] ?? '-' }}</td>
            <td>{{ $product['registry'] ?? '-' }}</td>
            <td>{{ $product['class'] ?? '-' }}</td>
        </tr>     
        @endforeach
    </tbody>
</table>