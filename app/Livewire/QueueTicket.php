<?php

namespace App\Livewire;

use App\Models\Antrian;
use Livewire\Component;
use Livewire\Attributes\Title;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Layout;

class QueueTicket extends Component
{
    public Antrian $antrian; // Properti untuk menampung data antrian

    // Livewire akan otomatis mengisi properti $antrian dari URL
    public function mount(Antrian $antrian)
    {
        $this->antrian = $antrian;
    }

    public function downloadPdf()
    {
        // Buat PDF dari view 'pdf.ticket' dan teruskan data antrian
        $pdf = Pdf::loadView('pdf.ticket', ['antrian' => $this->antrian]);

        // Tentukan nama file yang akan di-download
        $filename = 'tiket-antrian-' . $this->antrian->no_antrian . '.pdf';

        // Kirim PDF ke browser untuk di-download
        return response()->streamDownload(
            fn() => print($pdf->output()),
            $filename
        );
    }

    #[Title('Tiket Antrian')]
    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.queue-ticket');
    }
}
