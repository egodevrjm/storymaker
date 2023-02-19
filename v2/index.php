<!DOCTYPE html>
<html>
<head>
	<title>AI Storymaker</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="main.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#">AI Storymaker</a>
</nav>

<div class="container my-4 text-center">
  <h1>Create a story</h1>
</div>

<div class="container-fluid">
	<form>
		<!-- Section 1: Story Title and Author Name -->
		<div class="form-group">
			<label for="storyTitle">Story Title</label>
			<input type="text" class="form-control" id="storyTitle" name="storyTitle" required>
		</div>
		
    

    <div class="form-group">
    <label class="form-section">
				<i class="fas fa-key"></i> Authors
			</label>
      <div class="form-row">
  <select class="form-control" id="authorName" name="authorName" required>
    <option value="">Select an author</option>
    <?php
      $authors = file_get_contents('json/authors.json');
      $authors = json_decode($authors, true);
      foreach ($authors as $author) {
        echo '<option value="' . $author . '">' . $author . '</option>';
      }
    ?>
  </select>
    </div>
</div>


		<!-- Section 2: Keywords from words.json -->
		<div class="form-group">
			<label class="form-section">
				<i class="fas fa-key"></i> Keywords
			</label>
      <div class="scroll-view">
			<?php
				$words = file_get_contents('json/words.json');
				$words = json_decode($words, true);
				foreach ($words as $word) {
					echo '<div class="form-check mb-2">';
					echo '<input class="form-check-input" type="checkbox" name="keywords[]" value="' . $word . '">';
					echo '<label class="form-check-label"> ' . $word . ' </label>';
					echo '</div>';
				}
			?>
      </div>
		</div>

		<!-- Section 3: Genres from genres.json -->
		<div class="form-group">
			<label class="form-section">
				<i class="fas fa-book"></i> Genres
			</label>
			<div class="form-row">
				<select class="form-control" id="genre" name="genre" required>
					<option value="">Select a genre</option>
					<?php
						$genres = file_get_contents('json/genres.json');
						$genres = json_decode($genres, true);
						foreach ($genres as $genre) {
							echo '<option value="' . $genre . '">' . $genre . '</option>';
						}
					?>
				</select>
			</div>
		</div>

    <!-- Section 4: Story Tropes from tropes.json -->
<div class="form-group">
  <label class="form-section">
    <i class="fas fa-trophy"></i> Tropes
  </label>
  <div class="scroll-view">
    <?php
      $tropes = file_get_contents('json/tropes.json');
      $tropes = json_decode($tropes, true);
      foreach ($tropes as $trope) {
        echo '<div class="form-check mb-2">';
        echo '<input class="form-check-input" type="checkbox" name="tropes[]" value="' . $trope . '">';
        echo '<label class="form-check-label"> ' . $trope . ' </label>';
        echo '</div>';
      }
    ?>
  </div>
</div>

<!-- Section 5: Show Prompt, Generate Story, Reset, and Save Story buttons -->
<div class="form-group">
  <label>Actions</label>
  <div class="form-row">
    <div class="btn-group" role="group">
    <button type="button" class="btn btn-primary" id="showPromptBtn" onclick="generatePrompt()">Show Prompt</button>
      <button type="submit" class="btn btn-success" id="generateStoryBtn">Generate Story</button>
      <button type="reset" class="btn btn-danger" id="resetBtn">Reset</button>
    </div>
  </div>
</div>
    </form>

    <div id="promptContainer" style="border: 1px solid #ccc; border-radius: 5px; padding: 10px; margin-top: 20px; background-color: #f5f5f5; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);"></div>


</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/8f7d0f5b5f.js" crossorigin="anonymous"></script>

<script>
  function generatePrompt() {
  // Get the values of the form inputs
  var storyTitle = document.getElementById("storyTitle").value;
  var keywords = document.getElementsByName("keywords[]");
  var genre = document.getElementById("genre").value;
  var tropes = document.getElementsByName("tropes[]");
  var authorSelect = document.getElementById("authorName");
  var author = authorSelect.options[authorSelect.selectedIndex].value;

  // Create an array of selected keywords and tropes
  var selectedKeywords = [];
  var selectedTropes = [];
  for (var i = 0; i < keywords.length; i++) {
    if (keywords[i].checked) {
      selectedKeywords.push(keywords[i].value);
    }
  }
  for (var i = 0; i < tropes.length; i++) {
    if (tropes[i].checked) {
      selectedTropes.push(tropes[i].value);
    }
  }
  
  // Generate the prompt paragraph
  var prompt = "Write a story of no less than 800 words and no more than 1500 words. It has the title '" + storyTitle + "' about " + selectedKeywords.join(", ") + " in the " + genre + " genre and including the " + selectedTropes.join(", ") + " story tropes. In the style of " + author + ".";

  // Display the prompt paragraph
  var promptEl = document.createElement("p");
  promptEl.textContent = prompt;
  var promptContainer = document.getElementById("promptContainer");
  promptContainer.innerHTML = "";
  promptContainer.appendChild(promptEl);
}

</script>

</body>
</html>
