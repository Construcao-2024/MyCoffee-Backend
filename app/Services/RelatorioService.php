<?php

namespace App\Services;

use App\Models\Compra;
use App\Models\Produto;
//use PDF; // Importando a facade do dompdf
use Barryvdh\DomPDF\Facade\Pdf as PDF;



class RelatorioService
{
    public function gerarRelatorio()
    {
        $compras = Compra::with('produtos')->get();
        $produtos = Produto::all();

        $pdf = PDF::loadView('relatorios.relatorio', ['compras' => $compras, 'produtos' => $produtos]);
        return $pdf->download('relatorio_compras_produtos.pdf');
    }
}
