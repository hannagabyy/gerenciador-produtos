<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use TCPDF;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function usersReport()
    {
        $users = User::all();

        // Configurar header personalizado
        $pdf = new CustomPDF();
        $pdf->SetTitle('Relatório de Usuários Cadastrados');
        $pdf->empresaNome = 'Nome da Empresa';
        $pdf->empresaEndereco = 'Endereço da Empresa';
        $pdf->empresaCNPJ = 'CNPJ: 00.000.000/0000-00';
        $pdf->logoPath = public_path('images/logo.png');
        Carbon::setLocale('pt_BR');
        $mes = Carbon::now()->translatedFormat('F / Y'); 
        $pdf->mesReferencia = ucfirst($mes);


        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 12);

        $pdf->Ln(30);
        $pdf->Cell(0, 15, 'Relatório de Usuários Cadastrados', 0, 1, 'C');
        $pdf->Ln(8);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(40, 10, 'ID', 1);
        $pdf->Cell(80, 10, 'Nome', 1);
        $pdf->Cell(70, 10, 'Email', 1);
        $pdf->Ln();

        $pdf->SetFont('helvetica', '', 10);
        foreach ($users as $user) {
            $pdf->Cell(40, 10, $user->id, 1);
            $pdf->Cell(80, 10, $user->name, 1);
            $pdf->Cell(70, 10, $user->email, 1);
            $pdf->Ln();
        }

        $pdf->Output('relatorio_produtos.pdf', 'D');
    }

    public function productsReport()
    {
        $products = Product::all();
        $totalItems = $products->sum('quantidade');
        $totalValue = $products->sum(fn($p) => $p->preco * $p->quantidade);

        $pdf = new CustomPDF();
        $pdf->empresaNome = 'Nome da Empresa';
        $pdf->empresaEndereco = 'Endereço da Empresa';
        $pdf->empresaCNPJ = 'CNPJ: 00.000.000/0000-00';
        $pdf->logoPath = public_path('images/logo.png');
        Carbon::setLocale('pt_BR');
        $mes = Carbon::now()->translatedFormat('F / Y'); 
        $pdf->mesReferencia = ucfirst($mes);


        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        $pdf->Ln(30);
        $pdf->Cell(0, 15, 'Relatório de Produtos em Estoque', 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(40, 10, 'ID', 1);
        $pdf->Cell(60, 10, 'Título', 1);
        $pdf->Cell(30, 10, 'Preço', 1);
        $pdf->Cell(30, 10, 'Quantidade', 1);
        $pdf->Cell(30, 10, 'Status', 1);
        $pdf->Ln();

        $pdf->SetFont('helvetica', '', 10);
        foreach ($products as $product) {
            $pdf->Cell(40, 10, $product->id, 1);
            $pdf->Cell(60, 10, $product->titulo, 1);
            $pdf->Cell(30, 10, 'R$ ' . number_format($product->preco, 2, ',', '.'), 1);
            $pdf->Cell(30, 10, $product->quantidade, 1);
            $pdf->Cell(30, 10, $product->status ? 'Ativo' : 'Inativo', 1);
            $pdf->Ln();
        }

        $pdf->Ln(10);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 10, 'Total de Itens: ' . $totalItems, 0, 1);
        $pdf->Cell(0, 10, 'Total de Valor em Estoque: R$ ' . number_format($totalValue, 2, ',', '.'), 0, 1);

        $pdf->Output('relatorio_produtos_estoque.pdf', 'D');
    }
}



class CustomPDF extends TCPDF
{
    public $empresaNome;
    public $empresaEndereco;
    public $empresaCNPJ;
    public $logoPath;
    public $mesReferencia;

    
    public function Header()
    {
       
        $this->SetFillColor(0, 188, 213);
        $this->Rect(45, 10, 90, 25, 'F');

        // Logo
        if (file_exists($this->logoPath)) {
            
            $this->Image($this->logoPath, 12, 10, 25, 25);
        }

        //dados da empresa
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('helvetica', 'B', 10);
        $this->SetXY(50, 12);
        $this->Cell(85, 5, $this->empresaNome, 0, 1);
        $this->SetXY(50, 17);
        $this->SetFont('helvetica', '', 10);
        $this->Cell(85, 5, $this->empresaEndereco, 0, 1);
        $this->SetXY(50, 22);
        $this->Cell(85, 5, $this->empresaCNPJ, 0, 1);


        //mês de referência
        $this->SetDrawColor(0, 0, 0); 
        $this->SetLineWidth(0.2);
        $this->SetFillColor(230, 230, 230); 
        $this->Rect(150, 10, 46, 25, 'FD');
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('helvetica', 'B', 9);
        $this->SetXY(140, 12);
        $this->Cell(60, 5, 'MÊS DE REFERÊNCIA', 0, 1, 'C');
        $this->SetXY(140, 23);
        $this->SetFont('helvetica', '', 14);
        $this->Cell(60, 5, $this->mesReferencia, 0, 1, 'C');
    }

    public function Footer()
    {
        
        $this->SetY(-15);

        // Cor de fundo do "rodapé"
        $this->SetFillColor(0, 188, 213);; // mesma cor do header
        $this->Rect(0, $this->GetY(), $this->getPageWidth(), 15, 'F');

        // Fonte e cor do texto
        $this->SetFont('helvetica', 'B', 10);
        $this->SetTextColor(255, 255, 255); // branco

        // Nome da empresa (canto esquerdo)
        $this->SetXY(10, $this->GetY() + 3);
        $this->Cell(0, 5, $this->empresaNome, 0, 0, 'L', false);

        // Página atual / total (canto direito)
        $this->SetXY(-50, $this->GetY() + 3);
        $this->Cell(40, 5, 'Página ' . $this->getAliasNumPage() . ' / ' . $this->getAliasNbPages(), 0, 0, 'R', false);
    }
}
