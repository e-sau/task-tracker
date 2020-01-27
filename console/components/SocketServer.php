<?php

namespace console\components;

use frontend\models\ChatLog;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class SocketServer implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }
    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        $this->sendHelloMessage($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }
    /**
     * @param ConnectionInterface $from
     * @param string $msg
     * @throws \yii\base\InvalidConfigException
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        $msgArray = json_decode($msg, true);

        if ($msgArray['type'] === ChatLog::SHOW_HISTORY) {
            $this->showHistory($from, $msgArray);
        } else {
            ChatLog::create($msgArray);
            foreach ($this->clients as $client) {
                $msgArray['created_at'] = \Yii::$app->formatter->format(time(), [
                    'datetime', 'php:d.m.Y H:i:s'
                ]);
                /**
                 * @var ConnectionInterface $client
                 */
                $this->sendMessage($client, $msgArray);
            }
        }
    }

    /**
     * @param ConnectionInterface $conn
     * @param array $msg
     * @throws \yii\base\InvalidConfigException
     */
    private function showHistory(ConnectionInterface $conn, array $msg)
    {
        $chatLogsQuery = ChatLog::find()->orderBy('created_at ASC');

        if (isset($msg['task_id'])) {
            $chatLogsQuery->andWhere(['task_id' => (int)$msg['task_id']]);
        }

        if (isset($msg['project_id'])) {
            $chatLogsQuery->andWhere(['project_id' => (int)$msg['project_id']]);
        }

        foreach ($chatLogsQuery->each() as $chatLog) {
            /**
             * @var ChatLog $chatLog
             */
            $this->sendMessage($conn, [
                'created_at' => \Yii::$app->formatter->format($chatLog->created_at, ['datetime', 'php:d.m.Y H:i:s']),
                'message'=>$chatLog->message,
                'username'=>$chatLog->username
            ]);
        }
    }
    /**
     * @param ConnectionInterface $conn
     * @param array $msg
     */
    private function sendMessage(ConnectionInterface $conn, array $msg)
    {
        $conn->send(json_encode($msg));
    }
    /**
     * @param ConnectionInterface $conn
     */
    private function sendHelloMessage(ConnectionInterface $conn)
    {
        $this->sendMessage($conn,['message' => 'Всем привет', 'username' => 'Чат студентов geekbrains.ru']);
    }
    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}