<?php

declare(strict_types=1);

namespace App\Services\Utils;

use Dompdf\Dompdf;

final class DomPdfService
{
    public function create(array $data): string
    {
        $template = require(app_path().'/../resources/pdf/statement_v3.php');
        $dompdf = new Dompdf();
        $dompdf->loadHtml($template($data));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }
}
