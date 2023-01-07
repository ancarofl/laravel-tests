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


class DailyReports extends Mailable
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
		$controlAttachments = collect([]);
		$realAttachments = collect([]);
		$realAttachments2 = collect([]);

		$controlAttachments->push(storage_path('\images\img1.jpg')); //$controlAttachments->push(public_path('\images\img1.jpg'));
		$controlAttachments->push(storage_path('\images\img2.jpg')); //$controlAttachments->push(public_path('\images\img2.jpg'));

		//$realAttachments->push(Excel::download(new UsersExport, 'Users.xlsx')->getFile());
		//$realAttachments->push(Excel::download(new UsersExport, 'Users2.xlsx')->getFile());

		//Excel::store(new UsersExport, 'Users.xlsx');

		$fileName = 'Users.xlsx';
		Excel::store(new UsersExport, $fileName, 'excel');
		$realAttachments->push($fileName);

		$fileName = 'Users2.xlsx';
		Excel::store(new UsersExport, $fileName, 'excel');
		$realAttachments->push($fileName);

		/* THIS DOES NOT WORK
		$fileName = Excel::download(new UsersExport, 'Users3.xlsx')->getFile();
		$realAttachments2->push($fileName);

		$fileName = Excel::download(new UsersExport, 'Users4.xlsx')->getFile();
		$realAttachments2->push($fileName);
		*/

		/* THIS DOES NOT WORK
		$filePath = Excel::store(new UsersExport, 'Users3.xlsx', 'excel')->getFile();
		$realAttachments2->push($filePath);
		$filePath = Excel::store(new UsersExport, 'Users4.xlsx', 'excel')->getFile();
		$realAttachments2->push($filePath);
		*/

		/*$fileName = 'Users3.xlsx';
		Excel::store(new UsersExport, $fileName, 'excel');
		$filePath = storage_path('excel' . $fileName);
		$realAttachments2->push($filePath);    
		
		$fileName = 'Users4.xlsx';
		Excel::store(new UsersExport, $fileName, 'excel');
		$filePath = storage_path('excel' . $fileName);
		$realAttachments2->push($filePath);*/   

        $email = $this->from('sendmail@gmail.com')
			->markdown('emails.daily-reports')
			/*->attach(
				Excel::download(new UsersExport, 'Users.xlsx')->getFile(), ['as' => 'Users.xlsx']
			)
			->attach(
				Excel::download(new UsersExport, 'Users2.xlsx')->getFile(), ['as' => 'Users2.xlsx']
			)*/
			;

		/* Attach control attachments */
		foreach ($controlAttachments as $filePath) {
			\Log::Debug("anca22 - FP CONTROL");
			\Log::Debug($filePath);
			$email->attach($filePath);
		}

		/* Attach real attachments */
		foreach ($realAttachments as $fileName) {
			\Log::Debug("anca22 - FP REAL");
			\Log::Debug($fileName);
			$email->attach(storage_path() . "/app/excel-downloads/" . $fileName);
		}

		/* Attach real attachments method 2
		foreach ($realAttachments2 as $filePath) {
			\Log::Debug("anca22 - FP REAL 2");
			\Log::Debug($filePath);
			$email->attach($filePath);
		} */

		//dd($email);


		return $email;
    }
}