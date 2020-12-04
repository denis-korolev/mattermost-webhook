<?php

declare(strict_types=1);

namespace Test\Functional;

use App\Mattermost\Attachment;
use App\Mattermost\AttachmentFactory;
use App\Mattermost\WebhookClient;
use App\Mattermost\MattermostClientInterface;
use App\Mattermost\Message;
use App\Mattermost\MessageHelper;
use App\Mattermost\Text;
use App\Mattermost\WebhookParams;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class MattermostTest extends TestCase
{
    private MattermostClientInterface $client;

    public function setUp(): void
    {
        parent::setUp();
        $httpClient = new Client(
            [
                'debug' => true,
            ]
        );

        $params = new WebhookParams('http://matermost:8065/hooks/dui7ons8et8sxpuhdxxj4todfw', 'town-square', 'tester');

        $this->client = new WebhookClient($httpClient, $params);
    }

    public function testSendFullMessage(): void
    {
        /** @codingStandardsIgnoreStart Generic.Files.LineLength */
        $attachment = (new Attachment())->setFallback('This is the fallback test for the attachment.')
            ->setSuccessColor()
            ->setPretext('This is optional pretext that shows above the attachment.')
            ->setText('This is the text. **Finaly!** :let_me_in: ')
            ->setAuthorName('Mattermost')
            ->setAuthorIcon('http://www.mattermost.org/wp-content/uploads/2016/04/icon_WS.png')
            ->setAuthorLink('http://www.mattermost.org/')
            ->setTitle('Example attachment', 'http://docs.mattermost.com/developer/message-attachments.html')
            ->addField('Long field', 'Testing with a very long piece of text that will take up the whole width of the table. And then some more text to make it extra long.', false)
            ->addField('Column one', 'Testing.', true)
            ->addField('Column two', 'Testing.', true)
            ->addField('Column one again', 'Testing.', true)
            ->setImageUrl('http://www.mattermost.org/wp-content/uploads/2016/03/logoHorizontal_WS.png')
            ->addAction(
                [
                    'name' => 'Some button text',
                    'integration' => [
                        'url' => 'https://my-post-api.example.org',
                        'context' => [
                            'user_id' => '123',
                            'secret_key' => 'bépo22',
                        ],
                    ]
                ]
            );
        /** @codingStandardsIgnoreEnd */

        $message = new Message('Testing', '', [$attachment]);

        $this->client->send($message);

        self::assertTrue(true);
    }

    public function testSendAlertMessage(): void
    {
        $descr = new Text();
        /** @codingStandardsIgnoreStart Generic.Files.LineLength */
        $descr->addLine("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.");
        $descr->addLine("# Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.");
        $descr->addLine("## Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.");
        $descr->addLine("### Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");
        $descr->addLine('```');
        $descr->addLine('[2020-10-08T13:35:03.260292+00:00] CLI.INFO');
        $descr->addLine('```');
        /** @codingStandardsIgnoreEnd */

        $attachment = AttachmentFactory::alertAttachment('All bad', $descr);

        $message = new Message('Testing Mattermost client', '', [$attachment]);

        $this->client->send($message);

        self::assertTrue(true);
    }

    public function testSendSuccessMessage(): void
    {
        $descr = new Text();
        $descr->addLine('Lorem ipsum');
        $descr->addLine('``` -e  -s ```');
        $descr->addLine('- kjpopjo');
        $descr->addLine('- kjpopjo');

        $attachment = AttachmentFactory::successAttachment('it`s OK', $descr);

        $message = new Message('Mattermost client testing ', '', [$attachment]);

        $this->client->send($message);

        self::assertTrue(true);
    }

    public function testSuccessBatchSend(): void
    {
        $randomString = MessageHelper::generateRandomString(6000);
        $messages = MessageHelper::createMessagesWithTextAttachments($randomString, '', '$text');
        $this->client->batchSend(...$messages);

        self::assertTrue(true);
    }
}
