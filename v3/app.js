function generateStory(event) {
  event.preventDefault();
  
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
  
  // Construct the prompt text
  var promptText = "Write a story of no less than 800 words and no more than 1500 words. It has the title '" + storyTitle + "' about " + selectedKeywords.join(", ") + " in the " + genre + " genre and including the " + selectedTropes.join(", ") + " story tropes. In the style of " + author + ".";

  // Make a request to the OpenAI API to generate the story
  fetch('/generate-story', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({prompt: promptText})
  })
  .then(response => response.json())
  .then(data => {
    // Display the generated story on the page
    var storyContainer = document.getElementById('storyContainer');
    storyContainer.innerHTML = '';
    var storyEl = document.createElement('p');
    storyEl.textContent = data.story;
    storyContainer.appendChild(storyEl);
  })
  .catch(error => console.error(error));
}
