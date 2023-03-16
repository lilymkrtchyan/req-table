
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <link rel="stylesheet" type="text/css" href="/public/styles/site.css" media="all">
</head>

<body>


  <main class="flowers">

    <p>We added the course with the following information: </p>

    <dl>
      <dt>Course Name</dt>
      <dd><?php echo htmlspecialchars($name); ?></dd>

      <dt>Requirement Type</dt>
      <dd><?php echo htmlspecialchars($type); ?></dd>

      <dt>Course Department</dt>
      <dd><?php echo htmlspecialchars($department); ?></dd>

      <dt>Course Code</dt>
      <dd><?php echo htmlspecialchars($code); ?></dd>

      <dt>Course Description</dt>
      <dd><?php echo htmlspecialchars($description); ?></dd>

    </dl>

  </main>

</body>

</html>
