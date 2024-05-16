<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connection.php';
$search = "";
// Single org data with org prphone

function getUserData($pdo, $phnNumber)
{
    try {
        $stmt = $pdo->prepare("SELECT org.*, orgcat.ocategory FROM org LEFT JOIN orgcat ON org.ocatindex = orgcat.ocatindex WHERE prphone = :phnNumber");
        $stmt->bindParam(':phnNumber', $phnNumber, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user;
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage());
        return false;
    }
};

// Single resume data with org prphone

function getResumeData($pdo, $phnNumber)
{
    try {
        $stmt = $pdo->prepare("SELECT resumes.*, org.orgindex FROM resumes LEFT JOIN org ON org.orgindex = resumes.orgindex WHERE prphone = :phnNumber");
        $stmt->bindParam(':phnNumber', $phnNumber, PDO::PARAM_STR);
        $stmt->execute();
        $resume = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resume;
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage());
        return false;
    }
}
function getResumeDataGuest($pdo, $rindex)
{
    try {
        $stmt = $pdo->prepare("SELECT resumes.*, org.orgindex FROM resumes LEFT JOIN org ON org.orgindex = resumes.orgindex WHERE rindex = :rindex");
        $stmt->bindParam(':rindex', $rindex, PDO::PARAM_STR);
        $stmt->execute();
        $resume = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resume;
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage());
        return false;
    }
}

// All posted jobs with OrgIndex

function getAllPostedJobs($pdo, $orgIndex)
{
    try {
        $stmt = $pdo->prepare("SELECT job.*, jobcat.jcategory AS categoryName FROM job LEFT JOIN jobcat ON job.jobcategory = jobcat.jcatindex WHERE orgindex = :orgIndex");
        $stmt->bindParam(':orgIndex', $orgIndex, PDO::PARAM_STR);
        $stmt->execute();
        $allJobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $allJobs;
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage());
        return false;
    }
}

// Number of Jobs in Database

function postedJobsNumber($pdo)
{
    try {
        $stmt = $pdo->prepare("SELECT * FROM job");
        $stmt->execute();
        $numberOfJobs = $stmt->rowCount();

        return $numberOfJobs;
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage());
    }
}

// Single Job based on Job ID

function getJob($pdo, $jobId)
{
    try {
        $stmt = $pdo->prepare("SELECT job.*, jobcat.jcategory AS categoryName FROM job LEFT JOIN jobcat ON job.jobcategory = jobcat.jcatindex WHERE jindex = :jindex");
        $stmt->bindParam(':jindex', $jobId, PDO::PARAM_STR);
        $stmt->execute();
        $job = $stmt->fetch(PDO::FETCH_ASSOC);

        return $job;
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage());
        return false;
    }
}

// All job categories

function getJobCategories($pdo)
{
    try {
        $stmt = $pdo->prepare("SELECT * FROM jobcat");
        $stmt->execute();
        $jobCatData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $jobCatData;
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage());
        return false;
    }
}

// All Organization Categories

function getOrgCategories($pdo)
{
    try {
        $stmt = $pdo->prepare("SELECT * FROM orgcat");
        $stmt->execute();
        $orgCatData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orgCatData;
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage());
        return false;
    }
}


function pageination_alljobrows($pdo, $search = '')
{
    try {
        $query = "SELECT job.*, jobcat.jcategory AS categoryName FROM job LEFT JOIN jobcat ON job.jobcategory = jobcat.jcatindex WHERE visibility = 1";
        if (isset($search) && !empty($search)) {
            $textSearchQuery = '';
            $searchKeywordList = explode(' ', trim($search));

            foreach ($searchKeywordList as $searchKey) {
                $textSearchQuery = $textSearchQuery . "job.jobtitle LIKE '%". $searchKey. "%' OR ";
            }
            $textSearchQuery = rtrim($textSearchQuery, 'OR ');
            $query = "SELECT job.*, jobcat.jcategory AS categoryName FROM job LEFT JOIN jobcat ON job.jobcategory = jobcat.jcatindex WHERE visibility = 1 AND $textSearchQuery";
        }
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $countjobrows =  $stmt->rowCount();

        return $countjobrows;
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage());
        return false;
    }
}

function pageination_alljobdetails($pdo, $initial_page, $limit, $search = "")
{
    try {
        $query = "SELECT job.*, jobcat.jcategory AS categoryName FROM job LEFT JOIN jobcat ON job.jobcategory = jobcat.jcatindex WHERE visibility = 1 LIMIT :limitnumber OFFSET :initialpage";

        if (isset($search) && !empty($search)) {
            $textSearchQuery = '';

            $searchKeywordList = explode(' ', trim($search));

            foreach ($searchKeywordList as $searchKey) {
                $textSearchQuery = $textSearchQuery . "job.jobtitle LIKE '%" . $searchKey . "%' OR ";
            }
            $textSearchQuery = rtrim($textSearchQuery, 'OR ');
            $query = "SELECT job.*, jobcat.jcategory AS categoryName FROM job LEFT JOIN jobcat ON job.jobcategory = jobcat.jcatindex WHERE visibility = 1 AND $textSearchQuery LIMIT :limitnumber OFFSET :initialpage";
        }
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':initialpage', $initial_page, PDO::PARAM_INT);
        $stmt->bindParam(':limitnumber', $limit, PDO::PARAM_INT);
        $stmt->execute();
        // $stmt->debugDumpParams();
        $alljobdetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $alljobdetails;
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage());
        return false;
    }
}

function pageination_allresumedetails($pdo, $initial_page, $limit, $search="")
{
    try {

        $query = "SELECT * FROM resumes WHERE visible = 1 LIMIT :limitnumber OFFSET :initialpage";

        if(isset($search) && !empty($search)){
            $textSearchQuery = '';
            $searchKeywordList = explode(' ', trim($search));

            foreach ($searchKeywordList as $searchKey) {
                $textSearchQuery = $textSearchQuery . "resumes.skilleduexp LIKE '%". $searchKey . "%' OR ";
            }
            $textSearchQuery = rtrim($textSearchQuery, 'OR ');
            $query = "SELECT * FROM resumes WHERE visible = 1 AND $textSearchQuery LIMIT :limitnumber OFFSET :initialpage";
        }

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':initialpage', $initial_page, PDO::PARAM_INT);
        $stmt->bindParam(':limitnumber', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $allresumedetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $allresumedetails;
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage());
        return false;
    }
}

function pageination_allresumerows($pdo, $search = '')
{
    try {
        $query = "SELECT * FROM resumes WHERE visible = 1";
        if (isset($search) && !empty($search)) {
            $textSearchQuery = '';
            $searchKeywordList = explode(' ', trim($search));

            foreach ($searchKeywordList as $searchKey) {
                $textSearchQuery = $textSearchQuery . "resumes.skilleduexp LIKE '%". $searchKey. "%' OR ";
            }
            $textSearchQuery = rtrim($textSearchQuery, 'OR ');
            $query = "SELECT * FROM resumes WHERE visible = 1 AND $textSearchQuery";
        }
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $countjobrows =  $stmt->rowCount();

        return $countjobrows;
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage());
        return false;
    }
}