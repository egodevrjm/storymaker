<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>AI Storytime - Generate a Story</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="main.css">
  </head>
  <body>

    <!-- NAVIGATION -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <a class="navbar-brand" href="index.php">AI Storytime</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Generate a Story</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="stories.php">Stories</a>
          </li>
        </ul>
      </div>
    </nav>
    <!-- END NAVIGATION -->

    <!-- BODY -->
    <div class="container">
      <h1 class="text-center mb-4">Create Your Story</h1>
      <form>
        <!-- TITLE -->
        <div class="form-group">
          <label for="title">Title:</label>
          <input type="text" class="form-control" id="title" name="title">
        </div>

        <!-- AUTHOR -->
        <div class="form-group">
          <label for="author">Author:</label>
          <input type="text" class="form-control" id="author" name="author">
        </div>

        <!-- KEYWORDS -->
        <div class="form-group">
          <label for="keywords">Keywords:</label><br>
          <?php
          // Load the keywords from the JSON file
          $json = file_get_contents('json/words.json');
          $keywords = json_decode($json, true);
          // Shuffle the array and select a random set of 30 keywords
          shuffle($keywords);
          $random_keywords = array_slice($keywords, 0, 30);
          // Loop through the selected keywords and display a checkbox for each one
          foreach ($random_keywords as $i => $keyword) {
            $id = 'keyword' . ($i + 1);
            echo '<div class="form-check form-check-inline">';
            echo '<input class="form-check-input" type="checkbox" id="' . $id . '" name="keywords[]" value="' . $keyword . '">';
            echo '<label class="form-check-label" for="' . $id . '">' . ucwords($keyword) . '</label>';
            echo '</div>';
          }
          ?>
        </div>

        <!-- GENRE -->
        <div class="form-group">
          <label for="genre">Genre:</label>
          <select class="form-control" id="genre" name="genre" required>
            <option value="" selected disabled>-- Select a genre --</option>
            <?php
            // Load the genres from the JSON file
            $json = file_get_contents('json/genres.json');
            $genres = json_decode($json, true);
            // Loop
            foreach ($genres as $genre) {
              echo '<option value="' . $genre . '">' . ucwords($genre) . '</option>';
            }
            ?>
          </select>
        </div>
    
        <!-- TROPES -->
        <div class="form-group">
          <label for="tropes">Tropes:</label><br>
          <?php
          // Load the tropes from the JSON file
          $json = file_get_contents('json/tropes.json');
          $tropes = json_decode($json, true);
          // Loop through the tropes and display a checkbox for each one
          foreach ($tropes as $i => $trope) {
            $id = 'trope' . ($i + 1);
            echo '<div class="form-check form-check-inline">';
            echo '<input class="form-check-input" type="checkbox" id="' . $id . '" name="tropes[]" value="' . $trope . '">';
            echo '<label class="form-check-label" for="' . $id . '">' . ucwords($trope) . '</label>';
            echo '</div>';
          }
          ?>
        </div>
    
        <!-- SUBMIT BUTTON -->
        <button type="button" class="btn btn-primary" id="create-story" onclick="generateStory()">Create a Story</button>
      </form>
    </div>
    
    <div id="output"></div>
    
    <!-- SCRIPTS -->
    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- END SCRIPTS -->
    </body>
</html>    