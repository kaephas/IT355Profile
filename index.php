
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
<div class="container" id="container">
    <div class="container">
        <div id="intro">
            <p>I’m Kaephas, and I believe that anything humans can do, they can do even better with a program.
                I’ve worked in numerous Agile teams to put my OOP and Full-Stack expertise into building quality
                web-based and Java applications. I efficiently interpret client needs and convert them into
                working product features. I’m seeking a place where I can be passionate about the work I’m doing
                and put my programming and problem-solving skills to its best use.
            </p>
            <p>I can easily be reached at:</p><p>kkain@mail.greenriver.edu</p>
        </div>
    </div>
    <div class="jumbotron kaephas" id="bio">
        <div class="accordion whiteShadow" id="bioExpand">
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
                            Programming, specifically Java.  We've been learning a lot about data structures, from
                            linked-lists to graphs to binary search-trees, and we'll be spending more time in the future
                            learning about those and more even more in-depth.</p>

                        <p>We've been working in Agile Scrum teams creating applications for real clients and I look forward
                            to continuing to learn how to work efficiently while collaborating. Our coming quarters will
                            involve working with new technologies and languages to further broaden our knowledge and
                            capabilities as we develop new applications for members of the community.
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
        <div class="accordion whiteShadow" id="portfolioExpand">
            <div class="card">
                <div class="card-header text-center" id="headingPortfolio">
                    <h2 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapsePortfolio" aria-expanded="true" aria-controls="collapsePortfolio">
                            Portfolio
                        </button>
                    </h2>
                </div>

                <div id="collapsePortfolio" class="collapse show" aria-labelledby="headingPortfolio" data-parent="#portfolioExpand">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="fs-tab" data-toggle="tab" href="#webdev" role="tab" aria-controls="webdev" aria-selected="true">Full Stack</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="java-tab" data-toggle="tab" href="#java" role="tab" aria-controls="java" aria-selected="false">Java</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#certs" role="tab" aria-controls="certs" aria-selected="false">Certifications</a>
                            </li>
                        </ul>
                        <!-- Tab swapped content -->
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="webdev" role="tabpanel" aria-labelledby="fs-tab">
                                <div class="row">
                                    <div class="col-md-4">
                                        <p>
                                            We've learned Full Stack Web Development beginning with HTML and CSS, and
                                            progressing to Javascript, JQuery, and PHP with SQL databases. Most recently I
                                            began
                                            working on an app that was a transition from a previous GRC capstone team:
                                            the <strong>Boxers with Parkinson's</strong> app.
                                        </p>
                                        <p>
                                            The app uses html, css, and js as the foundation, but I also had to begin to
                                            learn node.js, express, and a NoSQL database MongoDB. It then uses Cordova to
                                            convert the code into an Android app that the client uses on tablets. It's been
                                            a challenge working with pre-existing code and learning how all the pieces
                                            interact together but has also been really rewarding to make progress fixing
                                            bugs and working with the client to interpret his needs into working features.
                                        </p>
                                    </div>
                                    <!-- web dev example image -->
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col" id="RSBhook">
                                                <p>
                                                    Rock Steady Boxing, a 501 (c)(3) nonprofit organization, gives people with
                                                    Parkinson’s disease hope by improving their quality of life through a
                                                    non-contact boxing-based fitness curriculum. At Rock Steady Boxing, 43,000
                                                    fighters are fighting back against Parkinson's! We inherited the Boxers with
                                                    Parkinson's app from a previous student team to implement the final features and
                                                    bug fixes to prepare it for version 1.0! The Boxers with Parkinson's app stores
                                                    all boxer data and assessment results digitally, replacing the need for
                                                    cumbersome, paper files by giving coaches the ability to easily sign up and
                                                    assess new boxers of all physical capabilities. For the first time ever, there's
                                                    measurable, tangible data about the impact of aerobic and neurobic exercise on
                                                    Parkinson's Symptoms!
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <img class="certs" src="images/BWP1.png" alt="Boxers with Parkinson's Form">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col">
                                                <img class="certs" src="images/BWP2.png" alt="Sample Question">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="java" role="tabpanel" aria-labelledby="java-tab">
                                <div class="row">
                                    <div class="col-md-4">
                                        <p>The core language at GRC is Java and the program focuses heavily on making sure
                                            we understand all the major Data Structures. Many of programs I've  created
                                            involve working with binary operators, custom linked lists and search trees,
                                            and out latest project was a maze builder, using a graph to build the maze
                                            structure and depth- and breadth-first searches to traverse from start to
                                            finish with a number of cells scaling up to 1 million, printing the one correct
                                            path along the way and completing in less than 2 seconds.
                                        </p>
                                        <p>
                                            I've posted a screenshot of the end result to the right. I'd love to
                                            show some of the code I'm particularly proud of, but I wouldn't want to tempt
                                            any future students to reuse it!
                                        </p>
                                    </div>
                                    <!-- Java example image -->
                                    <div class="col-md-8">
                                        <img class="certs" src="images/maze.png" alt="completed maze">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="certs" role="tabpanel" aria-labelledby="contact-tab">
                                <div class="row">
                                    <div class="col-md-4">
                                        <p>I currently have my A+ certification, which I recently renewed, and in August 2020
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
</div>
<!-- jquery up in header in order for modal to function -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body> <!-- no matching ok - it's in the header.html -->
</html>


