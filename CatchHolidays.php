<?php


namespace Holiday;

use Symfony\Component\DomCrawler\Crawler;
use const http\Client\Curl\Versions\CURL;

class CatchHolidays
{
    public function catchRequest($baseUrl , $typeCalendar = 0 , $year , $month)
    {
        $url = $baseUrl.$typeCalendar.'/'.$year.'/'.$month;

        $curl = curl_init();
        curl_setopt($curl , CURLOPT_URL , $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false );

        $result = curl_exec($curl);

        curl_close($curl);
        return $result;
    }

    public function crawlHtml($html)
    {
        $crawler = new Crawler($html);
        $holidays = $crawler->filter('.eventHoliday')->text();
        return $holidays;
    }

    public function writeInFile($holidays)
    {
        $holidaysFile = fopen('holidays.txt' , 'w') or die('unable to open this fucking file');
        fwrite($holidaysFile , json_encode($holidays));
        fclose($holidaysFile);
    }

    public function getHolidays()
    {
        $baseUrl = "https://www.time.ir/fa/event/list/";
        for ($i = 1 ; $i< 13 ; $i++){
            $html = $this->catchRequest($baseUrl , '0' , '1400' ,'1');
            $holidays = $this->crawlHtml($html);
            $this->writeInFile($html);
        }

    }
}