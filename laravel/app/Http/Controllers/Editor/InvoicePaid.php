use NotificationChannels\SMSGatewayMe\SMSGatewayMeChannel;
use NotificationChannels\SMSGatewayMe\SMSGatewayMeMessage;
use Illuminate\Notifications\Notification;

class InvoicePaid extends Notification
{
    public function via($notifiable)
    {
        return [SMSGatewayMeChannel::class];
    }

    public function toSmsGatewayMe($notifiable)
    {
        return (new SMSGatewayMeMessage)->text('Your invoice has been paid');
    }
}