<!DOCTYPE html>
<html>
<head>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<meta charset=utf-8 />
<title>JS Bin</title>
<!--[if IE]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<style>
  article, aside, figure, footer, header, hgroup, 
  menu, nav, section { display: block; }
  img {
  padding:4px;
  margin:4px;
  border:1px solid #555;
  -webkit-border-radius:4px;
  -moz-border-radius:4px;
  border-radius:4px;
  }
</style>
</head>
<body>
  <article id="convert">
  <h1>Textile2HTML</h1>
  <h2>Initial Code</h2>
  <pre><?= $content_initial ?></pre>
  <h2>Converted Code</h2>
  <pre><?= htmlspecialchars($content)?></pre>
  <h2>Preview</h2>
  <?= $content ?>
</body>
</html>​
