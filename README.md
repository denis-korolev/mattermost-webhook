# Client to work with Cargomart webhook

```php
        
        use App\Mattermost\Attachment;
        use App\Mattermost\Message;
        use App\Mattermost\WebhookClient;
        use App\Mattermost\WebhookParams;
        use GuzzleHttp\Client;
        
        // Any PSR7 Client
        $psr7Client = new Client();
        $webhookParams = new WebhookParams('http://matermost/hooks/2222222222', 'town-square', 'tester');
        $client = new WebhookClient($psr7Client, $webhookParams);

        $attachment = (new Attachment())->setFallback('This is the fallback test for the attachment.')
            ->setSuccessColor()
            ->setPretext('This is optional pretext that shows above the attachment.')
            ->setText('This is the text. **Finaly!** :let_me_in: ');
            
        // you can add array of attachments
        $message = new Message('Testing Mattermost client', '', [$attachment]);

        $client->send($message);
        // or
        $client->batchSend([$message]);
```