<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use RBooks\Models\MailSchedule as MailSchedulee;
use RBooks\Models\MailScheduleHistory;
use RBooks\Models\MailProduct;

class MailSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test abc';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $mailschedules = MailSchedulee::where('sendmail_date', Carbon::now()->toDateString())->where('sendmail_status', 0)->get();

        foreach ($mailschedules as $mailschedule) {
            $usermail = $mailschedule->customer->email;
            $fullname = $mailschedule->customer->fullname;
            $content = MailProduct::where('next_product_id', $mailschedule->sendmail_product_id)->first()->content;
            Mail::send('mail.notification', ['content' => $content, 'fullname' => $fullname], function ($message) use ($content, $usermail) {
                $message->from('ibeeser@gmail.com', 'RBOOKS.VN');
                $message->to($usermail)->subject('SÁCH HAY MỖI TUẦN')->bcc(['it4@lamians.com', 'it3@lamians.com', 'it5@lamians.com']);
            });

            $sendmail_product_id = MailProduct::where('product_id', $mailschedule->sendmail_product_id)->first()->next_product_id;
            $aftersendday = MailProduct::where('next_product_id', $mailschedule->sendmail_product_id)->first()->aftersendday;
            $mailschedule = MailSchedulee::find($mailschedule->id);
            $mailschedule->sendmail_product_id = $sendmail_product_id;
            // $mailschedule->sendmail_date = substr(floor((strtotime($mailschedule->sendmail_date) + $aftersendday) / 86400), 1);
            $mailschedule->sendmail_date = Carbon::parse($mailschedule->sendmail_date)->addDay(1);
            if ($mailschedule->product_id == $sendmail_product_id) { // Dừng vòng đời gửi mail
                $mailschedule->sendmail_status = 1;
            }
            $mailschedule->save(); // cập nhật để gửi mail tiếp theo

            MailScheduleHistory::create([
                'customer_id' => $mailschedule->customer_id,
                'order_number' => $mailschedule->order_number,
                'order_date' => $mailschedule->order_date,
                'product_id' => $mailschedule->product_id,
                'sendmail_product_id' => $mailschedule->sendmail_product_id,
                'sendmail_date' => $mailschedule->sendmail_date,
                'sendmail_status' => $mailschedule->sendmail_status,
                'created_user_id' => $mailschedule->created_user_id,
                'updated_user_id' => $mailschedule->updated_user_id,
            ])->save();
        }
    }
}
