<?php
include('/View/components/body.php');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<nav class="poppins uppercase font-semibold text-white text-center py-5 bg-[#06118e] text-[max(2vw,3rem)] w-full">download History</nav>
<a class="flex bg-[#06118e] poppins uppercase font-semibold text-white w-42 text-center py-2.5 px-3 rounded-lg m-5 justify-evenly text-[max(1vw,1rem)]" href="studentlist.php"><span>Back</span><img src="/assets/icons/back-icon.svg" alt="back-icon"></a>
<?php
$folder = "downloads/";

if (isset($_POST['delete'])) {
    $itemToDelete = $_POST['item'];

    $safePath = realpath($folder . basename($itemToDelete));

    if ($safePath && strpos($safePath, realpath($folder)) === 0) {
        if (is_file($safePath)) {
            unlink($safePath);
        } elseif (is_dir($safePath)) {
            rmdir($safePath);
        }
    }
}

$items = scandir($folder);
echo "<h1 class='popppins text-2xl font-semibold mx-8.5 mb-5'>List of Downloaded file's </h1>";

foreach ($items as $item) {
    if ($item === '.' || $item === '..') continue;

    $fullPath = $folder . $item;
    echo "<div>";

    if (is_dir($fullPath)) {
        echo "<a href='$fullPath' target='_blank'>📁 <strong>$item</strong></a>";
    } else {
        echo " 
        <div class='mx-8.5 my-5 flex gap-5'>
            <a href='$fullPath' target='_blank' class='poppins bg-primary w-92 text-white flex gap-5 px-2 py-3 rounded-lg justify-evenly no-underline hover:underline'>
                $item
            </a>
            <form method='POST' style='display:inline'>
                <input type='hidden' name='item' value='$item'>
                <button class='poppins cursor-pointer bg-red-500 text-white gap-5 px-2 py-3 rounded-lg flex' type='submit' name='delete' onclick=\"return confirm('Delete $item?')\">
                    Delete <img src='/assets/icons/delete-icon.svg' />
                </button>
            </form>
        </div>";
    }
}

?>