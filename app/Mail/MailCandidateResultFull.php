<?php

namespace App\Mail;

use App\Models\Candidate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MailCandidateResultFull extends Mailable implements ShouldQueue
{
	use Queueable, SerializesModels;

	public $candidate;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Candidate $candidate)
	{
		$this->candidate = $candidate;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->subject('Thông báo: Đã tuyển đủ nhân sự')
			->markdown('emails.candidate_result_full');
	}
}
