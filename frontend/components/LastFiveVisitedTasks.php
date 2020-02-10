<?php

namespace frontend\components;

use yii\base\Component;
use yii\helpers\Html;
use yii\helpers\Url;

class LastFiveVisitedTasks extends Component
{
    public function init()
    {
        parent::init();
    }

    public function show()
    {
        $lastVisited = $this->getVisitedPages();
        $this->setVisitedPage();

        return Html::tag('p', 'Последние посещенные страницы: ', [
                'style' => 'font-weight: 600;'
            ])
            . Html::ul(array_reverse($lastVisited), [
                    'style' => 'padding-left: 15px; list-style: none;',
                    'itemOptions' => ['style' => 'margin-bottom: 5px']
                ]);
    }

    protected function setVisitedPage()
    {
        $lastVisited = [];

        for ($i = 1; $i < 6; $i++){
            $page = Url::previous('last_' . $i);
            if (!$page) {
                Url::remember($_SERVER['REQUEST_URI'], 'last_' . $i);
                return;
            }
            $lastVisited[$i] = $page;
        }

        foreach ($lastVisited as $k => $page) {
            if ($k === 1) continue;

            Url::remember($page, 'last_' . ($k - 1));

            if ($k === 5) {
                Url::remember($_SERVER['REQUEST_URI'], 'last_' . $k);
            }
        }
    }

    protected function getVisitedPages()
    {
        $lastVisited = [];

        for ($i = 1; $i < 6; $i++){
            $page = Url::previous('last_' . $i);
            if ($page) {
                $lastVisited[] = $page;
            } else {
                break;
            }
        }

        return $lastVisited;
    }
}