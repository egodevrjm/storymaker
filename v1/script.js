function generateStory() {
    // Get the values of the title, keywords, genre, and tropes fields
    var title = document.getElementById('title').value;
    var keywords = Array.from(document.querySelectorAll('input[name="keywords"]:checked')).map(el => el.value).join(', ');
    var genre = document.getElementById('genre').value;
    var tropes = Array.from(document.querySelectorAll('input[name="tropes"]:checked')).map(el => el.value).join(', ');
    
    // Create the prompt
    var prompt = 'Create a story with the title "' + title + '" that is built around the following keywords: ' + keywords + ', in the ' + genre + ' genre and incorporates the following tropes: ' + tropes + '. It should be at least 800 words.';
    
    // Set up the API request
    var apiUrl = 'https://api.openai.com/v1/engines/text-davinci-003/completions';
    var apiHeaders = {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer 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'
    };
    var apiBody = JSON.stringify({
      'prompt': prompt,
      'temperature': 0.7,
      'max_tokens': 1024
    });
  
    // Change the text of the button to "Generating..."
    var button = document.getElementById('create-story');
    button.textContent = 'Generating...';
  
    // Make the API request
    fetch(apiUrl, {
      method: 'POST',
      headers: apiHeaders,
      body: apiBody
    })
    .then(response => response.json())
    .then(data => {
      // Extract the generated story from the API response
      var story = data.choices[0].text;
  
      // Display the story on the page
      var storyElement = document.createElement('div');
      storyElement.classList.add('card', 'mt-3', 'p-3');
      storyElement.innerHTML = story.replace(/\n/g, '<br>');

      var outputDiv = document.getElementById('output');
      outputDiv.innerHTML = '';
      outputDiv.appendChild(storyElement);
  
      // Change the text of the button back to "Create a Story"
      button.textContent = 'Create a Story';
    })
    .catch(error => {
      // Display the error on the page
      var errorElement = document.createElement('div');
      errorElement.classList.add('alert', 'alert-danger', 'mt-3');
      errorElement.textContent = error.message;
      var outputDiv = document.getElementById('output');
      outputDiv.innerHTML = '';
      outputDiv.appendChild(errorElement);
  
      // Change the text of the button back to "Create a Story"
      button.textContent = 'Create a Story';
    });
}
