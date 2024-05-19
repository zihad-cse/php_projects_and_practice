<?php

$allJobsNumber = postedJobsNumber($pdo);

if (isset($_POST['jobs-pagination-limit'])) {
    $_SESSION['jobs-pagination-limit'] = $_POST['jobs-pagination-limit'];
} else if (isset($_POST['jobs-pagination-limit'])) {
    $_POST['jobs-pagination-limit'] = $_SESSION['jobs-pagination-limit'];
} else if (isset($_SESSION['jobs-pagination-limit'])) {
    $_POST['jobs-pagination-limit'] = $_SESSION['jobs-pagination-limit'];
} else {
    $_SESSION['jobs-pagination-limit'] = 10;
}


if (isset($_GET['jobpage'])) {
    $job_current_page = $_GET['jobpage'];
} elseif (!isset($_GET['jobpage'])) {
    $job_current_page = 1;
}

// Jobs pagination Start

$job_initial_page = ($job_current_page - 1) * $_SESSION['jobs-pagination-limit'];
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $numberofjobs = pageination_alljobrows($pdo, $_GET['search']);
} else {
    $numberofjobs = pageination_alljobrows($pdo);
}

$job_total_pages = ceil($numberofjobs / $_SESSION['jobs-pagination-limit']);

$landingpage_allJobDetails = pageination_alljobdetails($pdo, $job_initial_page, (isset($isIndex) ? 10 : $_SESSION['jobs-pagination-limit']), $search);

$alljobcategories = getJobCategories($pdo);




$job_first_page = 1;
$job_last_page = $job_total_pages;
$job_default_loop = 3;

$job_first_loop = $job_default_loop;
$job_last_loop = $job_default_loop;

if (($job_current_page - $job_first_page) <= 3) {
    $job_first_loop = $job_current_page - $job_first_page;
    $job_last_loop = $job_default_loop + ($job_default_loop - $job_first_loop);
    // echo "F First Loop $job_first_loop </br>";
    // echo "F Last Loop $job_last_loop </br>";
}

if (($job_last_page - $job_current_page) <= 3) {
    $job_last_loop = $job_last_page - $job_current_page;
    $job_first_loop = $job_default_loop + ($job_default_loop - $job_last_loop);
    // echo "L First Loop $job_first_loop </br>";
    // echo "L Last Loop $job_last_loop </br>";
}
if (($job_first_loop == 3) && ($job_last_loop == 3)) {
    $jobsPagination_rangeFirstNumber = $job_current_page - 3;
    if ($jobsPagination_rangeFirstNumber <= $job_first_page) {
        $jobsPagination_rangeFirstNumber = $job_first_page;
    }
    $jobsPagination_rangeLastNumber = $job_current_page + 3;
    if ($jobsPagination_rangeLastNumber >= $job_last_page) {
        $jobsPagination_rangeLastNumber = $job_last_page;
    }
}
if (($job_first_loop < 3) && ($job_last_loop > 3)) {
    $jobsPagination_rangeFirstNumber = $job_current_page - $job_first_loop;
    if ($jobsPagination_rangeFirstNumber <= $job_first_page) {
        $jobsPagination_rangeFirstNumber = $job_first_page;
    }
    $jobsPagination_rangeLastNumber = $job_current_page + $job_last_loop;
    if ($jobsPagination_rangeLastNumber >= $job_last_page) {
        $jobsPagination_rangeLastNumber = $job_last_page;
    }
}
if (($job_first_loop > 3) && ($job_last_loop < 3)) {
    $jobsPagination_rangeFirstNumber = $job_current_page - $job_first_loop;
    if ($jobsPagination_rangeFirstNumber <= $job_first_page) {
        $jobsPagination_rangeFirstNumber = $job_first_page;
    }
    $jobsPagination_rangeLastNumber = $job_current_page + $job_last_loop;
    if ($jobsPagination_rangeLastNumber >= $job_last_page) {
        $jobsPagination_rangeLastNumber = $job_last_page;
    }
}

// Jobs Pagination End

$allResumesNumber = pageination_allresumerows($pdo);

if (isset($_POST['resumes-pagination-limit'])) {
    $_SESSION['resumes-pagination-limit'] = $_POST['resumes-pagination-limit'];
} else if (isset($_POST['resumes-pagination-limit'])) {
    $_POST['resumes-pagination-limit'] = $_SESSION['resumes-pagination-limit'];
} else if (isset($_SESSION['resumes-pagination-limit'])){
    $_POST['resumes-pagination-limit'] = $_SESSION['resumes-pagination-limit'];
} else {
    $_SESSION['resumes-pagination-limit'] = 10;
}

if (isset($_GET['resumepage'])) {
    $resume_current_page = $_GET['resumepage'];
} elseif (!isset($_GET['resumepage'])) {
    $resume_current_page = 1;
}

$resume_initial_page = ($resume_current_page - 1) * $_SESSION['resumes-pagination-limit'];


if (isset($_GET['search']) && !empty($_GET['search'])) {
    $numberofresumes = pageination_allresumerows($pdo, $_GET['search']);
} else {
    $numberofresumes = pageination_allresumerows($pdo);
}
$resume_total_pages = ceil($numberofresumes / $_SESSION['resumes-pagination-limit']);

$allresumedetails = pageination_allresumedetails($pdo, $resume_initial_page, (isset($isIndex) ? 10 : $_SESSION['resumes-pagination-limit']), $search);



$resume_first_page = 1;
$resume_last_page = $resume_total_pages;
$resume_default_loop = 3;

$resume_first_loop = $resume_default_loop;
$resume_last_loop = $resume_default_loop;

if (($resume_current_page - $resume_first_page) <= 3) {
    $resume_first_loop = $resume_current_page - $resume_first_page;
    $resume_last_loop = $resume_default_loop + ($resume_default_loop - $resume_first_loop);
}
if (($resume_last_page - $resume_current_page) <= 3) {
    $resume_last_loop = $resume_last_page - $resume_current_page;
    $resume_first_loop = $resume_default_loop + ($resume_default_loop - $resume_last_loop);

}
if (($resume_first_loop == 3) && ($resume_last_loop == 3)) {
    $resumePagination_rangeFirstNumber = $resume_current_page - 3;
    if ($resumePagination_rangeFirstNumber <= $resume_first_page) {
        $resumePagination_rangeFirstNumber = $resume_first_page;
    }
    $resumePagination_rangeLastNumber = $resume_current_page + 3;
    if ($resumePagination_rangeLastNumber >= $resume_last_page) {
        $resumePagination_rangeLastNumber = $resume_last_page;
    }
}
if (($resume_first_loop < 3) && ($resume_last_loop > 3)) {
    $resumePagination_rangeFirstNumber = $resume_current_page - $resume_first_loop;
    if ($resumePagination_rangeFirstNumber <= $resume_first_page) {
        $resumePagination_rangeFirstNumber = $resume_first_page;
    }
    $resumePagination_rangeLastNumber = $resume_current_page + $resume_last_loop;
    if ($resumePagination_rangeLastNumber >= $resume_last_page) {
        $resumePagination_rangeLastNumber = $resume_last_page;
    }
}
if (($resume_first_loop > 3) && ($resume_last_loop < 3)) {
    $resumePagination_rangeFirstNumber = $resume_current_page - $resume_first_loop;
    if ($resumePagination_rangeFirstNumber <= $resume_first_page) {
        $resumePagination_rangeFirstNumber = $resume_first_page;
    }
    $resumePagination_rangeLastNumber = $resume_current_page + $resume_last_loop;
    if ($resumePagination_rangeLastNumber >= $resume_last_page) {
        $resumePagination_rangeLastNumber = $resume_last_page;
    }
}