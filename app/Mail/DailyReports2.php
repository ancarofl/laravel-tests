<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;


class DailyReports2 extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Daily Reports',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.daily-reports',
        );
    }


    public function build()
    {
		$attachments = collect([]);

		$fileName = 'ProductInventory.xlsx';
		Excel::store(new ProductInventoryExport, $fileName);
		$realAttachments->push($fileName);

		$fileName = 'DailySalesReport.xlsx';
		Excel::store(new SalesReport('daily', 0, 0), $fileName);
		$realAttachments->push($fileName);

        $email = $this
			->from('sendmail@gmail.com')
			->markdown('emails.daily-reports');

		foreach ($attachments as $fileName) {
			$email->attach(storage_path() . "/app/" . $fileName);
		}

		return $email;
    }

    public function build2()
    {
        // Store exports and add their file names to attachments array
        $attachments = collect([]);

        $fileName = 'ProductInventory.xlsx';
        // Arguments here are export, file name and the disk to store it to. You could also leave out 'excel', then it would be stored inside your default disk.
        Excel::store(new ProductInventoryExport, $fileName, 'excel');
        $realAttachments->push($fileName);

        $fileName = 'DailySalesReport.xlsx';
        Excel::store(new SalesReport('daily', 0, 0), $fileName, 'excel');
        $realAttachments->push($fileName);

        // Start build email
        $email = $this
            ->from('sendmail@gmail.com')
            ->markdown('emails.daily-reports');

        // Attach the files to the email
        foreach ($attachments as $fileName) {
            // Adjust the next line based on where you store the files
            $email->attach(storage_path() . "/app/excel-downloads/" . $fileName);
        }

        return $email;
    }
}