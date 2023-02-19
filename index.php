<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>AI Storymaker</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    
    <!-- Include jQuery library -->
    <script src="scripts/jquery-3.6.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</head>


<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#"><img src="img/logo_trans.png" alt="PlotSmith Logo"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Contact</a>
            </li>
        </ul>
    </div>
</nav>



<!-- Page Content -->
<div class="container">
<div class="text-center">
    <h1 class="display-4 font-weight-bold mb-4">Create a Story</h1>
</div>


<!-- Form -->
<form method="post">

<!-- TITLE -->
<div class="form-group">
    <label for="title">Title</label>
    <div class="input-group">
        <input type="text" class="form-control" id="title" name="title" placeholder="Enter a title">
        <span class="input-group-btn">
            <button class="btn btn-secondary" type="button" id="random-title-btn">Random</button>
        </span>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // When the "Random" button is clicked
        document.querySelector("#random-title-btn").addEventListener('click', function() {
            // Load the titles from the JSON file
            fetch('json/titles.json')
                .then(response => response.json())
                .then(data => {
                    // Get a random title
                    const title = data[Math.floor(Math.random() * data.length)];
                    // Update the Title text box with the random title
                    document.querySelector("#title").value = title;
                });
        });
    });
</script>






<!-- AUTHOR STYLE -->
<div class="form-group">
    <label for="author-style">Author Style</label>
    <select class="form-control" id="author-style" name="author-style">
        <option value="">Select an author style</option>
        <?php
            // Load the author styles from the JSON file
            $json = file_get_contents('json/author_styles.json');
            $author_styles = json_decode($json);

            // Display an option for each author style
            foreach ($author_styles as $author_style) {
                echo '<option value="' . $author_style . '">' . $author_style . '</option>';
            }
        ?>
    </select>
</div>


        
<!-- KEYWORDS from Json file -->
<div class="form-group">
    <label for="keywords">Keywords</label>
    <div class="keywords">
        <?php
            // Load the keywords from the JSON file
            $json = file_get_contents('json/words.json');
            $keywords = json_decode($json);

            // Shuffle the keywords
            shuffle($keywords);

            // Display a checkbox for each keyword
            $num_keywords = count($keywords);
            $keywords_per_load = 30;
            for ($i = 0; $i < min($num_keywords, $keywords_per_load); $i++) {
                $keyword = $keywords[$i];
                echo '<div class="form-check form-check-inline">';
                echo '<input class="form-check-input" type="checkbox" id="keyword-' . $i . '" name="keywords[]" value="' . $keyword . '">';
                echo '<label class="form-check-label" for="keyword-' . $i . '">' . $keyword . '</label>';
                echo '</div>';
            }
        ?>
    </div>
    <?php if ($num_keywords > $keywords_per_load) { ?>
        <button type="button" class="btn btn-sm btn-link" id="show-more-keywords-btn">Show More</button>
    <?php } ?>
</div>

<script>
    $(document).ready(function() {
        var num_keywords_loaded = <?php echo $keywords_per_load; ?>;
        var num_keywords = <?php echo $num_keywords; ?>;

        // When the "Show More" button is clicked
        $("#show-more-keywords-btn").click(function() {
            // Load the keywords from the JSON file
            $.getJSON("json/words.json", function(data) {
                // Shuffle the keywords
                data.sort(() => Math.random() - 0.5);
                // Display a checkbox for each keyword
                for (var i = num_keywords_loaded; i < Math.min(num_keywords, num_keywords_loaded + <?php echo $keywords_per_load; ?>); i++) {
                    var keyword = data[i];
                    var input = '<div class="form-check form-check-inline">';
                    input += '<input class="form-check-input" type="checkbox" id="keyword-' + i + '" name="keywords[]" value="' + keyword + '">';
                    input += '<label class="form-check-label" for="keyword-' + i + '">' + keyword + '</label>';
                    input += '</div>';
                    $(".keywords").append(input);
                }
                num_keywords_loaded += <?php echo $keywords_per_load; ?>;
                // Hide the button if all keywords have been loaded
                if (num_keywords_loaded >= num_keywords) {
                    $("#show-more-keywords-btn").hide();
                }
            });
        });
    });
</script>

<!-- TROPES from Json file -->
<div class="form-group">
    <label for="tropes">Tropes</label>
    <div class="tropes">
        <?php
            // Load the tropes from the JSON file
            $json = file_get_contents('json/tropes.json');
            $tropes = json_decode($json);

            // Shuffle the tropes
            shuffle($tropes);

            // Display a checkbox for each trope
            $num_tropes = count($tropes);
            $tropes_per_load = 30;
            for ($i = 0; $i < min($num_tropes, $tropes_per_load); $i++) {
                $trope = $tropes[$i];
                echo '<div class="form-check form-check-inline">';
                echo '<input class="form-check-input" type="checkbox" id="trope-' . $i . '" name="tropes[]" value="' . $trope . '">';
                echo '<label class="form-check-label" for="trope-' . $i . '">' . $trope . '</label>';
                echo '</div>';
            }
        ?>
    </div>
    <?php if ($num_tropes > $tropes_per_load) { ?>
        <button type="button" class="btn btn-sm btn-link" id="show-more-tropes-btn">Show More</button>
    <?php } ?>
</div>

<script>
    $(document).ready(function() {
        var num_tropes_loaded = <?php echo $tropes_per_load; ?>;
        var num_tropes = <?php echo $num_tropes; ?>;

        // When the "Show More" button is clicked
        $("#show-more-tropes-btn").click(function() {
            // Load the tropes from the JSON file
            $.getJSON("json/tropes.json", function(data) {
                // Shuffle the tropes
                data.sort(() => Math.random() - 0.5);
                // Display a checkbox for each trope
                for (var i = num_tropes_loaded; i < Math.min(num_tropes, num_tropes_loaded + <?php echo $tropes_per_load; ?>); i++) {
                    var trope = data[i];
                    var input = '<div class="form-check form-check-inline">';
                    input += '<input class="form-check-input" type="checkbox" id="trope-' + i + '" name="tropes[]" value="' + trope + '">';
                    input += '<label class="form-check-label" for="trope-' + i + '">' + trope + '</label>';
                    input += '</div>';
                    $(".tropes").append(input);
                }
                num_tropes_loaded += <?php echo $tropes_per_load; ?>;
                // Hide the button if all tropes have been loaded
                if (num_tropes_loaded >= num_tropes) {
                    $("#show-more-tropes-btn").hide();
                }
            });
        });
    });
</script>



<!-- GENRE -->
<div class="form-group">
    <label for="genre">Genre</label>
    <select class="form-control" id="genre" name="genre">
        <option value="">Select a genre</option>
        <?php
            // Load the genres from the JSON file
            $json = file_get_contents('json/genres.json');
            $genres = json_decode($json);

            // Display an option for each genre
            foreach ($genres as $genre) {
                echo '<option value="' . $genre . '">' . $genre . '</option>';
            }
        ?>
    </select>
</div>


<!-- 20-WORD PLOT OUTLINE -->
<div class="form-group">
    <label for="plot-outline">20-Word Plot Outline</label>
    <div class="input-group">
        <input type="text" class="form-control" id="plot-outline" name="plot-outline" placeholder="Enter a 20-word plot outline">
        <span class="input-group-btn">
            <button class="btn btn-secondary" type="button" id="random-plot-btn">Random</button>
        </span>
    </div>
</div>

<script>
    // When the "Random" button is clicked
    document.getElementById("random-plot-btn").addEventListener("click", function() {
        // Load the plots from the JSON file
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Parse the JSON response
                var data = JSON.parse(this.responseText);
                // Get a random plot
                var plot = data[Math.floor(Math.random() * data.length)];
                // Update the 20-Word Plot Outline text box with the random plot
                document.getElementById("plot-outline").value = plot;
            }
        };
        xhr.open("GET", "json/plots.json", true);
        xhr.send();
    });
</script>




<!-- BUTTON -->
    <button type="submit" class="btn btn-primary">Generate Story</button>



</form>


<!-- Footer -->
<footer class="py-5 bg-light">
    <div class="container">
        <p class="m-0 text-center text-black">AI Storymaker &copy; from A Trip to Space Projects</p>
    </div>
    <!-- /.container -->
</footer>

</div>

</body>
</html>