<?php

$name = $_POST["name"]; //untrusted
$department = $_POST["department"]; //untrusted
$type = $_POST["type"]; //untrusted
$code = $_POST["code"]; //untrusted


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
    'code' => 'hidden'
  );

  //Values
  $form_values = array(
    'name' => '',
    'type' => '',
    'department' => '',
    'code' => ''
  );

    //Sticky Values
    $sticky_values = array(
      'name' => '',
      'department' => '',
      'code' => '',
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

      //Name of the Course
      if ($form_values['name'] == '') {
        $form_valid = False;
        $form_feedback['name'] = '';
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
          "INSERT INTO courses (name, code, department, type) VALUES (:coursename, :coursecode, :coursedepartment, :coursetype);",
          array(
            ':coursename' => $name,
            ':coursecode' => $code,
            ':coursedepartment' => $department,
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

      <p>The list of the courses (course numbers, codes, and departments) are copied from Cornell University's Information Science website.</p>
</center>

<h4>Insert a new requirement below</h4>
<?php if (!$show_confirmation) { ?>
<form method="post" action="/" novalidate>

<p class="feedback <?php echo $form_feedback['name']; ?>">Please insert the course name.</p>
        <div class="request">
          <div class="label"><label for="name">Class name:</label></div>
          <div class="input"><input id="name" type="text" name="name" value="<?php echo $sticky_values['name']; ?>"></div>
        </div>

        <p class="feedback <?php echo $form_feedback['department']; ?>">Please insert the department that the course is in.</p>
        <div class="request">
          <div class="label"><label for="department">Department:</label></div>
          <div class="input"><input id="department" type="text" name="department" value="<?php echo $sticky_values['department']; ?>"></div>
        </div>

        <p class="feedback <?php echo $form_feedback['code']; ?>">Please insert the course code.</p>
        <div class="request">
          <div class="label"><label for="code">Course Code:</label></div>
          <div class="input"><input id="code" type="text" name="code" value="<?php echo $sticky_values['code']; ?>"></div>
        </div>



        <p class="feedback <?php echo $form_feedback['type']; ?>">Please select at least one type.</p>
        <div class="request" role="group" aria-labelledby="type">
          <div class="label" id="type">Requirement Type:</div>

            <div class="input">
              <input type="radio" id="core" name="type" value=0 <?php echo $sticky_values['core']; ?>>
              <label for="core">Core Requirement</label>
            <div>
              <input type="radio" id="math" name="type" value=3 <?php echo $sticky_values['math']; ?>>
              <label for="math">Mathematics Requirement</label>
            </div>
            <div>
              <input type="radio" id="cs" name="type" value=5 <?php echo $sticky_values['cs']; ?>>
              <label for="cs">Computer Science Requirement</label>
            </div>
            <div>
              <input type="radio" id="elective" name="type" value=1 <?php echo $sticky_values['elective']; ?>>
              <label for="elective">Elective</label>
            </div>
            <div>
              <input type="radio" id="concentration" name="type" value=2 <?php echo $sticky_values['concentration']; ?>>
              <label for="concentration">Concentration Requirement</label>
            </div>
            <div>
              <input type="radio" id="statistics" name="type" value=4 <?php echo $sticky_values['statistics']; ?>>
              <label for="statistics">Statistics Requirement</label>
            </div>
          </div>
          </div>

        <div class="right">
          <input type="submit" value="Submit Course" name="submit-course" />
        </div>
      </form>
      <?php } else { ?>


      <p>We added the course with the following information: </p>

<dl>

<div class="form">
<div class="confirmation-row">
 <div class="label"> <dt>Course Name</dt> </div>
  <div class="input"> <dd><?php echo htmlspecialchars($record['name']); ?></dd> </div>
</div>

<div class="confirmation-row">
  <div class="label"><dt>Requirement Type</dt> </div>
  <div class="input"> <dd><?php echo htmlspecialchars(TYPE[$record['type']]); ?></dd> </div>
</div>

<div class="confirmation-row">
 <div class="label"> <dt>Course Department</dt> </div>
 <div class="input"> <dd><?php echo htmlspecialchars($record['department']); ?></dd> </div>
</div>

<div class="confirmation-row">
 <div class="label"> <dt>Course Code</dt> </div>
  <div class="input"> <dd><?php echo htmlspecialchars($record['code']); ?></dd> </div>
</div>
</div>

</dl>
<?php } ?>

</body>

</html>
