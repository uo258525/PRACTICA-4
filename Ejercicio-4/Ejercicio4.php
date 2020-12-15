<?php
session_start();

class NewsItem
{
    public $title;
    public $sectionName;
    public $publicationDate;
    public $image;
    public $trailText;
    public $url;
}


class Ejercicio4
{
    public $results;

    public function getNews()
    {
        $url = "https://content.guardianapis.com/search?";
        $url .= "api-key=61926119-b31a-49c3-b2d2-f693537f90c3";
        $url .= "&show-fields=thumbnail,trailText";
        $datos = file_get_contents($url);
        $json = json_decode($datos);


        $this->printNews($json);
    }

    public function printNews($json){
        $this->results = array();
        foreach($json->response->results as $item){

            $obj = new NewsItem();
            $obj->title = $item->webTitle;
            $obj->sectionName = $item->sectionName;
            $obj->publicationDate = $item->webPublicationDate;
            $obj->image = $item->fields->thumbnail;
            $obj->trailText = $item->fields->trailText;
            $obj->url = $item->webUrl;

            array_push($this->results, $obj);
        }
     }
}
$ejercicio4=new Ejercicio4();
$ejercicio4->getNews();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="Elena Díaz Gutiérrez -UO258525" name="author">
    <meta content="width=device-width,user-scalable=yes" name="viewport">
    <title>Ejercicio 4</title>
    <link rel="stylesheet" type="text/css" href="Ejercicio4.css">

</head>

<body>
    <header>
        <h1>Consumo de servicios Web de noticias</h1>
    </header>

    <main>

        <section id="result">
            <h2 id="resultHeader">Últimas noticias</h2>
            <?php foreach($ejercicio4->results as $key=>$value){ ?>
                <section class='news'>

                <h3 class='newsHeader'> <?php echo $value->title; ?> </h3>
                <p class='newsSubtitle'> <?php echo $value->sectionName; ?>.  <?php echo $value->publicationDate; ?> </p>

                <div class='thumbnail'>
                    <img class='thumbnailImg' alt='imagen' src="<?php echo $value->image; ?>"/>
                </div>

                <div class='trailText'>
                <p> 
                    <?php echo $value->trailText; ?> 
                    (<a href="<?php echo $value->url; ?>">Read more about: <?php echo $value->title; ?></a>)
                </p>
                </div>

                </section>
            <?php } ?>
        </section>

    </main>


</body>

</html>