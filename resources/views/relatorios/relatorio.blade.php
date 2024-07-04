<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Compras e Produtos</title>
    <style>
        /* Adicione aqui o estilo do seu PDF */
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Relatório de Compras e Produtos</h1>

    <h2>Compras</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Data</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($compras as $compra)
                <tr>
                    <td>{{ $compra->id }}</td>
                    <td>{{ $compra->created_at }}</td>
                    <td>{{ $compra->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Produtos</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produtos as $produto)
                <tr>
                    <td>{{ $produto->id }}</td>
                    <td>{{ $produto->nome }}</td>
                    <td>{{ $produto->preco }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
