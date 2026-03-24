<?php

namespace App\Jobs;

use App\Exports\OrderMonthyReportExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Generate monthly order report and store to disk. Can be extended to email the file.
 */
class GenerateReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param string|null $email Optional email to send report to (when mail is implemented)
     * @param array{from: string, to: string} $dateRange Date range for report (Y-m-d)
     */
    public function __construct(
        public ?string $email,
        public array $dateRange
    ) {
    }

    /**
     * Execute the job: export monthly report and store file.
     */
    public function handle(): void
    {
        try {
            $filename = 'reports/monthly_' . ($this->dateRange['from'] ?? date('Y-m-d')) . '.xlsx';
            Excel::store(new OrderMonthyReportExport(), $filename, 'local');
            Log::info('Report generated', ['file' => $filename, 'date_range' => $this->dateRange]);
            // When ReportGeneratedMail exists: Mail::to($this->email)->send(new ReportGeneratedMail($filename));
        } catch (\Throwable $e) {
            Log::error('GenerateReportJob failed', ['error' => $e->getMessage(), 'date_range' => $this->dateRange]);
            throw $e;
        }
    }
}
