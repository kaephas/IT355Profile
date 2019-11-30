
<?php
$title = "Kaephas";
include("./includes/header.html");

// form submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    // get database connection
    require('../mysqli_connect.php');

    // check for errors
    $errors = [];

    // empty name field
    if (empty($_POST['name']) || $_POST['name'] == "") {
        $errors[] = 'Please enter your name.';
    } else if (isset($_POST['name'])) {
        $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
    }

    // email can be empty, but if not, make sure it's valid
    if(isset($_POST['email']) && $_POST['email'] != "") {
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email.';
        } else {
            $email = mysqli_real_escape_string($dbc, $_POST['email']);
            $query = "SELECT email FROM guestbook WHERE email='$email'";
            $result = @mysqli_query($dbc, $query);
            $rows = mysqli_num_rows($result);
        }
    } else {
        $email = "";
    }

    // company can be empty, if not, trim and sql escape string
    if(isset($_POST['company']) && $_POST['company'] != "") {
        $company = mysqli_real_escape_string($dbc, trim($_POST['company']));
    } else {
        $company = "";
    }

    // linkedIn link can be empty, if not, make sure it's a valid URL, run escape string for double layer
    if(isset($_POST['linked']) && $_POST['linked'] != "") {
        if(!filter_var($_POST['linked'], FILTER_VALIDATE_URL)) {
            $errors[] = 'Please enter a valid URL for linkedIn';
        } else {
            $linked = mysqli_real_escape_string($dbc, $_POST['linked']);
        }
    } else {
        $linked = "";
    }

    // how we met can be empty, if not, sql escape string
    if(isset($_POST['howMet']) && $_POST['howMet'] != "") {
        $howMet = mysqli_real_escape_string($dbc, $_POST['howMet']);
    } else {
        $howMet = "";
    }

    // comments can be empty, if not, sql escape it
    if(isset($_POST['comments']) && $_POST['comments'] != "") {
        $comments = mysqli_real_escape_string($dbc, $_POST['comments']);
    } else {
        $howMet = "";
    }

    // if there aren't any errors
    if(empty($errors)) {
        // if email check query got a value, they've already signed
        if($rows > 0) {
            echo '<div class="container text-center"><h3>Thanks, but you\'ve already signed my book!</h3></div>';
            $email = "";
        } else {
            // insert into database -- set date to now - 3 hours (server is on EST)
            $query = "INSERT INTO guestbook (name, email, company, linked_in, how_met, comments, signed)
                  VALUES ('$name', '$email', '$company', '$linked', '$howMet', '$comments', (NOW() - INTERVAL 3 HOUR));";
            $result = @mysqli_query($dbc, $query);

            // if the insert was successful
            if($result) {
                echo '<div class="container text-center"><h3>Thank you for signing my Guestbook!</h3></div>';
            } else {
                // something went wrong...
                echo '<div class="container text-center"><h3>Something went wrong with the database!</h3></div>';
            }
        }

    } else {
        // error modal
        echo '
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Error!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">';

        // loop through errors in errors[]
        echo '<p class="error">The following error(s) occurred:<br>';
        foreach ($errors as $msg) {
            echo " - $msg<br>\n";
        }
        echo '</p>
                            <p>Please try again.</p><p><br></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-purple" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>';

        // script to activate modal
        echo '<script src="scripts/modal.js"></script>';
    }

    mysqli_close($dbc);
}


?>

<!-- the actual page -->
<!-- bio section -->
<div>

    <p>I’m Kaephas, and I believe that, anything humans can do, they can do even better with a program.
        I’ve worked in numerous Agile teams to put my OOP and Full-Stack expertise into building quality
        web-based and Java applications. I efficiently interpret client needs and convert them into
        working product features. I’m seeking a place where I can be passionate about the work I’m doing
        and put my programming and problem-solving skills to its best use.
    </p>

</div>
<div class="jumbotron kaephas" id="bio">
    <div class="accordion" id="bioExpand">
        <div class="card">
            <div class="card-header text-center" id="headingBio">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseBio" aria-expanded="true" aria-controls="collapseBio">
                        Bio
                    </button>
                </h2>
            </div>

            <div id="collapseBio" class="collapse show" aria-labelledby="headingBio" data-parent="#bioExpand">
                <div class="card-body">
                    <p>I'm in my Senior year at GRC and am excited to continue learning more about Object-Oriented
                        Programming, specifically Java.  We've been learning a lot about data structures, from linked-
                        lists to graphs to binary search-trees, and we'll be spending more time in the future learning
                        about those and more even more in-depth.</p>

                    <p>For our Full-STack Web Development classes, we've been working in Agile teams using the Scrum
                        Methodology and I look forward to continue learning how to work efficiently while collaborating.
                        Our coming quarters will involve working on new technologies and languages to further broaden
                        our knowledge and capalities.
                    </p>

                    <p>In my current job, I work with clients and other employees to solve numerous IT related problems
                        along with any other miscellaneous things that come up. When I can't solve the problem myself,
                        I work with other IT professionals to troubleshoot network and PC-related issues that come up in
                        a retail environment. Finding those solutions is what has given me a strong foundation and
                        general understanding of PC hardware and software. I also research new technologies for our
                        business and give recommendations on moving foward or passing on them.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- portfolio section -->
<div class="jumbotron" id="portfolio">
    <div class="accordion" id="portfolioExpand">
        <div class="card">
            <div class="card-header text-center" id="headingPortfolio">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapsePortfolio" aria-expanded="true" aria-controls="collapsePortfolio">
                        Portfolio
                    </button>
                </h2>
            </div>

            <div id="collapsePortfolio" class="collapse" aria-labelledby="headingPortfolio" data-parent="#portfolioExpand">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#java" role="tab" aria-controls="java" aria-selected="true">Java</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#webdev" role="tab" aria-controls="webdev" aria-selected="false">Web Dev</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#certs" role="tab" aria-controls="certs" aria-selected="false">Certifications</a>
                        </li>
                    </ul>
                    <!-- Tab swapped content -->
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="java" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <p>The program at GRC has emphasizes Java and focuses heavily on making sure we understand
                                        Data Structures. Some examples of programs I've created involve working with binary
                                        operators, linked lists, and out latest project was a webcrawler, working with threads.
                                        I've posted a couple screenshots of a couple of the projects to the right. I'd love to
                                        show some of the code I'm particularly proud of, but I wouldn't want any future
                                        students getting any ideass!</p>
                                </div>
                                <!-- Java example image -->
                                <div class="col-md-8">
                                    <img class="certs" src="images/webcrawl.png" alt="webcrawler">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="webdev" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <p>We're learning Full Stack Web Development and began with HTML and CSS, progressing
                                    on to Javascript and JQuery, and recently have begun to learn PHP and how to connect
                                    our website to SQL databases. This website is one such project, as it allows us to
                                    view the database of people who have signed our guestbook. I've written this whole
                                    site from scratch (Boostrap 4 counts right?) and set up the database myself (albeit
                                    a simple one). We've had a couple other projects involving all the components as well
                                    throughout the most recent quarter, and you can see some screen shots of the finished
                                    products to the right (or below on Mobile--it's a responsive site!)</p>
                                </div>
                                <!-- web dev example image -->
                                <div class="col-md-8">
                                    <img class="certs" src="images/icecream.png" alt="ice cream shoppe">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="certs" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <p>I currently have my A+ certification, which I recently renewed, and as of the coming summer, in August 2019
                                        I expect to have finished my Scrum Master certification. I also received my MTA: Networking Fundamentals in 2016.</p>
                                </div>
                                <!--load cert images-->
                                <div class="col-md-8 row">
                                    <div class="col"><img class="certs" src="./images/aplus.png" alt="A+"></div>
                                    <div class="col"><img class="certs" src="./images/scrum.png" alt="Scrum"></div>
                                    <div class="col"><img class="certs" src="./images/mta.png" alt="MTA"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- guestbook form -->
<div class="jumbotron" id="guestbook">
    <div class="accordion" id="guestExpand">
        <div class="card">
            <div class="card-header text-center" id="headingGuest">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseGuest" aria-expanded="true" aria-controls="collapseGuest">
                        Guestbook
                    </button>
                </h2>
            </div>

            <div id="collapseGuest" class="collapse" aria-labelledby="headingGuest" data-parent="#guestExpand">
                <div class="card-body">
                    <form action="index.php" method="post">
                        <div class="row">
                            <!-- 2 items per column on mid-sized or larger -->
                            <div class="form-group col-md-6">
                                <label class="required" for="name">Name</label>
                                <input class="form-control" type="text" name="name" id="name" required
                                       value="<?php if(isset($_POST['name'])) echo $_POST['name']; ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" name="email" id="email"
                                       value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="company">Company</label>
                                <input class="form-control" type="text" name="company" id="company"
                                       value="<?php if(isset($_POST['company'])) echo $_POST['company']; ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="linked">LinkedIn page</label>
                                <input class="form-control" name="linked" id="linked"
                                       value="<?php if(isset($_POST['linked'])) echo $_POST['linked']; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="howMet">How did we meet?</label>
                                <select class="form-control" name="howMet" id="howMet">
                                    <option value="" <?php if(!isset($_POST['howMet'])) echo 'selected'; ?>>Choose an option...</option>
                                    <option value="Green River" <?php if($_POST['howMet'] == 'Green River') echo 'selected'; ?>>Green River</option>
                                    <option value="Meetup" <?php if($_POST['howMet'] == 'Meetup') echo 'selected'; ?>>Meetup</option>
                                    <option value="Job Fair" <?php if($_POST['howMet'] == 'Job Fair') echo 'selected'; ?>>Job Fair</option>
                                    <option value="Guest Speaker" <?php if($_POST['howMet'] == 'Guest Speaker') echo 'selected'; ?>>Guest Speaker</option>
                                    <option value="LinkedIn Connection" <?php if($_POST['howMet'] == 'LinkedIn Connection') echo 'selected'; ?>>LinkedIn Connection</option>
                                    <option value="Job Interview" <?php if($_POST['howMet'] == 'Job Interview') echo 'selected'; ?>>Job Interview</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="comments">Comments</label>
                                <textarea class="form-control" name="comments" id="comments" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <!-- class btn-purple for purple button matching color scheme -->
                        <button type="submit" class="btn btn-purple">Sign Guestbook</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- jquery up in header in order for modal to function -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body> <!-- no matching ok - it's in the header.html -->
</html>


