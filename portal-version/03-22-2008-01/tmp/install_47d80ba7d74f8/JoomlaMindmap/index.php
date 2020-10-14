<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sitemap of <? echo $_SERVER['SERVER_NAME'] ?> as a mind map</title>

<script type="text/javascript" src="flashobject.js"></script>

<style type="text/css">
        /* hide from ie on mac \*/
    html {
        height: 100%;
        overflow: hidden;
    }

    #flashcontent {
        height: 100%;
    }
    /* end hide */

    body {
        font-family:Arial, Helvetica, sans-serif;
        color:#333333;
        line-height:175%;
                                margin:0px;
        height: 100%;
        background-color: #9999ff;
    }
</style>
</head>

<body>
                          <? echo base64_decode('VGhpcyBtaW5kIG1hcCB3YXMgZ2VuZXJhdGVkIGJ5IDxhIGhyZWY9Imh0dHA6Ly93d3cuZ29lcm1lemVyLmRlIiB0aXRsZT0iSG9tZSBvZiBKb29tbGFNaW5kbWFwIiB0YXJnZXQ9Il9ibGFuayI+Sm9vbWxhTWluZG1hcDwvYT4=').'. Click on node expands it, click on red arrow heads over to entry...'; ?>
        <div id="flashcontent">
            Flash plugin or Javascript are turned off. Please activate both and reload to view the whole site as one mind map.
        </div>

        <script type="text/javascript">
                // <![CDATA[
                var fo = new FlashObject("visorFreemind.swf", "visorFreeMind", "100%", "100%", 6, "#9999ff");
                fo.addParam("quality", "high");
                fo.addParam("bgcolor", "#ffffff");
                fo.addVariable("min_alpha_buttons",20);
                            fo.addVariable("max_alpha_buttons",100);
                fo.addVariable("openUrl", "_parent");
                fo.addVariable("defaultWordWrap","200");
                fo.addVariable("defaultToolTipWordWrap",200);
                fo.addVariable("initLoadFile", "sitemap.php");
                fo.addVariable("startCollapsedToLevel","2");
                fo.addVariable("mainNodeShape","ellipse");
                fo.addVariable("scaleTooltips","false");
                fo.addVariable("unfoldAll","false");
                fo.addVariable("justMap","false");
                fo.write("flashcontent");
                // ]]>
        </script>
</body>
</html>