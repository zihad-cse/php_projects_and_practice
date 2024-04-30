<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connection.php';
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

function getPostedJobData ($pdo, $phnNumber)
{
    try
    {
        $stmt = $pdo->prepare("SELECT job.*, org.orgindex FROM job LEFT JOIN org ON org.orgindex = job.orgindex WHERE prphone = :phnNumber");
        $stmt->bindParam(':phnNumber', $phnNumber, PDO::PARAM_STR);
        $stmt->execute();
        $jobs = $stmt->fetch(PDO::FETCH_ASSOC);

        return $jobs;
    }
    catch (PDOException $e)
    {
        error_log("Error: " . $e->getMessage());
        return false;
    }
}

function getJobCategories($pdo){
    try
    {
        $stmt = $pdo->prepare("SELECT * FROM jobcat");
        $stmt->execute();
        $jobCatData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $jobCatData;
    }
    catch (PDOException $e)
    {
        error_log("Error: ". $e->getMessage());
        return false;
    }
}

function getOrgCategories($pdo){
    try
    {
        $stmt = $pdo->prepare("SELECT * FROM orgcat");
        $stmt->execute();
        $orgCatData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orgCatData;
    } 
    catch (PDOException $e)
    {
        error_log("Error: ". $e->getMessage());
        return false;
    }
}