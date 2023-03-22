<?php

$name = $_POST["name"]; //untrusted
$department = $_POST["department"]; //untrusted
$type = $_POST["type"]; //untrusted
$code = $_POST["code"]; //untrusted
$description = $_POST["description"]; //untrusted

const TYPE = array(
    0 => 'Core',
    1 => 'Elective',
    2 => 'Concentration',
    3 => 'Math',
    4 => 'Statistics',
    5 => 'Coding'
  );


  // Initialize
  $show_confirmation = False;

  // feedback messages
  $form_feedback = array(
    'name' => 'hidden',
    'type' => 'hidden',
    'department' => 'hidden',
    'code' => 'hidden',
    'description' => 'hidden'
  );

  //Values
  $form_values = array(
    'name' => '',
    'type' => '',
    'department' => '',
    'code' => '',
    'description' => ''
  );

    //Sticky Values
    $sticky_values = array(
      'name' => '',
      'department' => '',
      'code' => '',
      'description' => '',
      'core' => '',
      'math' => '',
      'cs' => '',
      'elective' => '',
      'concentration' => ''
    );

  $db = open_sqlite_db('secure/site.sqlite');

    //Check if the form is submitted
    if (isset($_POST['submit-course'])){

    //Assume form is valid
    $form_valid = True;

      //Store as variables
      $form_values['name'] = trim($_POST['name']); //untrusted
      $form_values['type'] = trim($_POST['type']); //untrusted
      $form_values['department'] = trim($_POST['department']); //untrusted
      $form_values['code'] = trim($_POST['code']); //untrusted
      $form_values['description'] = trim($_POST['description']); //untrusted

      //Name of the Course
      if ($form_values['name'] == '') {
        $form_valid = False;
        $form_feedback['name'] = '';
      }
      if ($form_values['description'] == '') {
        $form_valid = False;
        $form_feedback['description'] = '';
      }
      if ($form_values['department'] == '') {
        $form_valid = False;
        $form_feedback['department'] = '';
      }
      if ($form_values['code'] == '') {
        $form_valid = False;
        $form_feedback['code'] = '';
      }
      if ($form_values['type'] == '') {
        $form_valid = False;
        $form_feedback['type'] = '';
      }



      //Check if the data is valid
      if ($form_valid){

        $show_confirmation = True;

        $result = exec_sql_query(
          $db,
          "INSERT INTO courses (name, code, department, type, description) VALUES (:coursename, :coursecode, :coursedepartment, :coursetype, :coursedescription);",
          array(
            ':coursename' => $name,
            ':coursecode' => $code,
            ':coursedepartment' => $department,
            ':coursedescription' => $description,
            ':coursetype' => $type
          )
        );

        // query courses table
        $result = exec_sql_query(
          $db, 'SELECT * FROM courses;'
        );

        //get records from the courses table
        $records = $result -> fetchall();

      } else {
        $sticky_values['name'] = $form_values['name'];
        $sticky_values['department'] = $form_values['department'];
        $sticky_values['code'] = $form_values['code'];
        $sticky_values['description'] = $form_values['description'];
        $sticky_values['core'] = ($form_values['type'] == 'core' ? 'checked' : '');
        $sticky_values['math'] = ($form_values['type'] == 'math' ? 'checked' : '');
        $sticky_values['cs'] = ($form_values['type'] == 'cs' ? 'checked' : '');
        $sticky_values['elective'] = ($form_values['type'] == 'elective' ? 'checked' : '');
        $sticky_values['concentration'] = ($form_values['type'] == 'concentration' ? 'checked' : '');

          }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Info Sci Courses Catalog</title>

  <link rel="stylesheet" type="text/css" href="/public/styles/site.css" media="all">
</head>

<body>

<?php
    // query DB
    $result = exec_sql_query($db, 'SELECT * FROM courses;');
    $records = $result->fetchAll();
    ?>
<center>
    <h1>INFORMATION SCIENCE MAJOR REQUIREMENTS</h1>
<table>
      <?php foreach ($records as $record) { ?>
       <tr>

          <div class="course">
            <th><?php echo htmlspecialchars($record['name']); ?></th>

            <th><?php echo htmlspecialchars($record['code']); ?></th>

            <th><?php echo htmlspecialchars($record['department']); ?></th>


             <th> <?php echo htmlspecialchars(TYPE[$record['type']]); ?> </th>


          </div>
      </tr>
      <?php } ?>
      </table>

      <p>The list of the courses (course numbers, codes, departments, and some of the descriptions) are copied from Cornell University's Information Science website.</p>
</center>

<?php if (!$show_confirmation) { ?>
<form method="post" action="/" novalidate>

<p class="feedback <?php echo $form_feedback['name']; ?>">Please insert the course name.</p>
        <div class="label-input">
          <label for="name">Class name:</label>
          <input id="name" type="text" name="name" value="<?php echo $sticky_values['name']; ?>">
        </div>

        <p class="feedback <?php echo $form_feedback['department']; ?>">Please insert the department that the course is in.</p>
        <div class="label-input">
          <label for="department">Department:</label>
          <input id="department" type="text" name="department" value="<?php echo $sticky_values['department']; ?>">
        </div>

        <p class="feedback <?php echo $form_feedback['code']; ?>">Please insert the course code.</p>
        <div class="label-input">
          <label for="code">Course Code:</label>
          <input id="code" type="text" name="code" value="<?php echo $sticky_values['code']; ?>">
        </div>

        <p class="feedback <?php echo $form_feedback['description']; ?>">Please type in a short description for the course.</p>
        <div class="label-input">
          <label for="description">Course Description:</label>
          <input id="description" type="text" name="description" value="<?php echo $sticky_values['description']; ?>">
        </div>

        <p class="feedback <?php echo $form_feedback['type']; ?>">Please select at least one type.</p>
        <div role="group" aria-labelledby="requirement_type">
          <div id="type">Requirement Type:</div>

          <div>
            <div>
              <input type="radio" id="core" name="type" value="core" <?php echo $sticky_values['core']; ?>>
              <label for="core">Core Requirement</label>
            </div>
            <div>
              <input type="radio" id="math" name="type" value="math" <?php echo $sticky_values['math']; ?>>
              <label for="math">Mathematics Requirement</label>
            </div>
            <div>
              <input type="radio" id="cs" name="type" value="cs" <?php echo $sticky_values['cs']; ?>>
              <label for="cs">Computer Science Requirement</label>
            </div>
            <div>
              <input type="radio" id="elective" name="type" value="elective" <?php echo $sticky_values['elective']; ?>>
              <label for="elective">Elective</label>
            </div>
            <div>
              <input type="radio" id="concentration" name="type" value="concentration" <?php echo $sticky_values['concentration']; ?>>
              <label for="concentration">Concentration Requirement</label>
            </div>
          </div>
        </div>

        <div class="right">
          <input type="submit" value="submit-course" name="submit-course" />
        </div>
      </form>
      <?php } else { ?>


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
<?php } ?>

</body>

</html>
