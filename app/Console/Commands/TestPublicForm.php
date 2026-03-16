<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestPublicForm extends Command
{
    protected $signature = 'test:pdf';
    protected $description = 'Generates a dummy PDF file logic for testing.';

    public function handle()
    {
        // Require FPDF. FPDF might not be installed but we don't necessarily need an elaborate PDF. We can just create a random file with .pdf extension as long as it passes mimes format check. Wait! mimes check reads mime type, so it actually expects a real PDF format.
        // We will just upload a minimal valid PDF string and save it to test.pdf.
        
        $pdfContent = "%PDF-1.4\n1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] >>\nendobj\nxref\n0 4\n0000000000 65535 f\n0000000009 00000 n\n0000000058 00000 n\n0000000115 00000 n\ntrailer\n<< /Size 4 /Root 1 0 R >>\nstartxref\n188\n%%EOF";
        
        file_put_contents(storage_path('app/public/test.pdf'), $pdfContent);
        
        $this->info('Dummy PDF generated at: ' . storage_path('app/public/test.pdf'));
        
        return Command::SUCCESS;
    }
}
