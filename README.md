![Test status on master](https://github.com/denis-korolev/mattermost-webhook/workflows/Master%20status/badge.svg)

Client to work with Cargomart webhook
----------------------------------------

This library will help you send messages to Mattermost by Webhook.

Installation / Usage
--------------------

Install the latest version via [composer](https://getcomposer.org/):

```bash
composer require denis-korolev/mattermost-webhook
```

Here is an example of usage. 
--------------------

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

If you need to send huge text, more than 4000 symbols, you can use 
```php 
    $messages = MessageHelper::createMessagesWithTextAttachments('huge text, longer 4000 symbols');
    $client->batchSend(...$messages);
```
It will create Message[], which you can send.
It will break text by pages and qoute it by \```
So you just send it and it will print at chat one after another. 