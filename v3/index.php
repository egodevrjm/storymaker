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
	<form onsubmit="return generateStory()">
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

<!-- Section 5: Generate Story button -->
<div class="btn-group" role="group">
<button type="submit" class="btn btn-primary" id="generateStoryBtn">Generate Story</button>
  <div class="progress ml-3 my-1" style="display: none;">
    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="progress"></div>
  </div>
</div>



</form>
</div>

<!-- Section 6: Generated Story -->
<div class="form-group">
  <label for="storyContainer" class="form-section">
    <i class="fas fa-file-alt"></i> Generated Story
  </label>
  <div id="storyContainer"></div>
</div>


<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/8f3d2f5d3f.js" crossorigin="anonymous"></script>

<!-- Custom JS -->
<script>
function generateStory() {
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
  
  // Generate the prompt
  var prompt = "Write a story of no less than 800 words and no more than 1500 words. It has the title '" + storyTitle + "' about " + selectedKeywords.join(", ") + " in the " + genre + " genre and including the " + selectedTropes.join(", ") + " story tropes. In the style of " + author + ".";

  // Change the text of the button to "Generating..." and disable it
  var generateStoryBtn = document.getElementById("generateStoryBtn");
  generateStoryBtn.textContent = "Generating...";
  generateStoryBtn.disabled = true;

  // Show the progress bar and set its initial value
  var progressBar = document.getElementById("progressBar");
  progressBar.style.display = "block";
  progressBar.setAttribute("value", 0);

  // Make an API request to OpenAI's GPT-3 API
  var apiKey = "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";
  var apiUrl = "https://api.openai.com/v1/engines/text-davinci-002/completions";
  var requestData = {
    prompt: prompt,
    temperature: 0.5,
    max_tokens: 2048,
    n: 1,
    stop: "\n"
  };
  fetch(apiUrl, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "Authorization": "Bearer " + apiKey
    },
    body: JSON.stringify(requestData)
  })
  .then(function(response) {
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }
    return response.json();
  })
  .then(function(responseData) {
    // Display the generated story on the page
    var story = responseData.choices[0].text;
    var storyEl = document.createElement("p");
    storyEl.textContent = story;
    var storyContainer = document.getElementById("storyContainer");
    storyContainer.innerHTML = "";
    storyContainer.appendChild(storyEl);

    // Change the text of the button back to "Generate Story" and re-enable it
    generateStoryBtn.textContent = "Generate Story";
    generateStoryBtn.disabled = false;

    // Hide the progress bar
    progressBar.style.display = "none";
  })
  .catch(function(error) {
  console.error("Error generating story: " + error.message);
  alert("An error occurred while generating the story. Please try again later.");

  // Change the text of the button back to "Generate Story" and re-enable it
  generateStoryBtn.textContent = "Generate Story";
  generateStoryBtn.disabled = false;

  // Hide the progress bar
  progressBar.style.display = "none";
  progressBar.setAttribute("aria-valuenow", "0");
  progressBar.style.width = "0%";
  progressBar.textContent = "";
});
}

</script>

</body>
</html>
