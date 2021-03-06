<?php
include 'lib/db.php';
include 'lib/common.php';
include_once 'common/header.php';
function isAuthorized()
{
    return isset($_SESSION["email"])
        && isset($_SESSION["user_id"])
        && isset($_SESSION["first_name"])
        && isset($_SESSION["last_name"]);
}
function thereWillBeTasks()
{
    echo '<div class="nav-login">';
    echo '</div>';
}
function notAuthorizedContent()
{
    echo '<div id="no-login">';
    echo '<p> Vítej na Caltasku!<br><br>
            Máš účet? <a href="login.php">Přihláš se</a>.<br>Pokud ne, můžeš se <a href="register.php">zaregistrovat</a>.</p>';
    echo '</div>';
}
function isValidTask($title)
{
    return !empty($title);
}
if (!isset($_SESSION['sort_by'])) {
    $_SESSION['sort_by'] = 'title';
}
if (!empty($_POST['issubmit'])) {
    if (isValidTask($_POST['title'])) {
        $category = $_POST['category'] == "-999" ? null : $_POST['category'];
        $dateArray = parseDate2($_POST['deadline']);
        //echo parseDate2($_POST['deadline']);
        if (isValidDate($dateArray)) {
            $result = createTask($_SESSION['user_id'], $_POST['title'], $dateArray, $category);
            if ($result) {
                header("Location: index.php");
            } else {
                writeErrorMessage('Nepodařilo se vytvořit task');
            }
        } else {
            writeErrorMessage('Datum je ve špatném formátu');
        }
    } else {
        writeErrorMessage('Musíš vyplnit vše');
    }
}
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'finished' && !empty($_GET['task_id'])) {
        $result = updateTaskFinished($_GET['task_id'], $_SESSION['user_id']);
        if ($result) {
            header("Location: index.php");
        } else {
            writeErrorMessage('Nepodařilo se dokončit task');
        }
    }
    if ($action == 'delete' && !empty($_GET['task_id'])) {
        $result = deleteTask($_GET['task_id'], $_SESSION['user_id']);
        if ($result) {
            header("Location: index.php");
        } else {
            writeErrorMessage('Nepodařilo se smazat task');
        }
    }
    if ($action == 'sort') {
        if (!empty($_GET['sort_by'])) {
            $_SESSION['sort_by'] = $_GET['sort_by'];
        }
        header("Location: index.php");
    }
}
function getClassNameForTask($done)
{
    return $done ? "task-finished" : "";
}
?>

    <section class="main-container">
        <div class="main-wrapper">

            <?php
            if (isAuthorized()) {
                thereWillBeTasks();
                ?>
                <div id="tasks">
                    <form class="form" method="POST" action="index.php">
                        <div>
                            <input id="task-title" class="large" name="title" type="text" title="Název úkolu je povinný"
                                   placeholder="Zadejte úkol..." required>
                        </div>
                        <div>
                            <select id="task-category" class="small" name="category">
                                <option value="-999">-Vyberte velikost příjmu-</option>
                                <?php
                                $result = findCategories($_SESSION['user_id']);
                                while ($row = $result->fetch()) {
                                    echo "<option value=\"" . $row['category_id'] . "\">" . $row['income'] . ",- Kč" . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <input class="small deadline" name="deadline" type="date" autocomplete="off"
                                   placeholder="Zadejte termín splnění ve formátu dd.mm.yyyy...">
                        </div>
                        <input type="hidden" name="issubmit" value="true">
                        <button type="submit" name="submit">Přidat</button>
                    </form>
                    <div id="task-list">
                        <table>
                            <thead>
                            <tr>
                                <?php
                                $sort_by = $_SESSION['sort_by'];
                                if ($sort_by == 'deadline') {
                                    echo "<th width=\"400\">Termín</th>";
                                    } else {
                                    echo "<th width=\"400\"><a href=\"index.php?action=sort&sort_by=deadline  \">Termín</a></th>";
                                    }
                                if ($sort_by == 'title') {
                                    echo "<th width=\"400\">Úkol</th>";
                                } else {
                                    echo "<th width=\"400\"><a href=\"index.php?action=sort&sort_by=title  \">Úkol</a></th>";
                                }
                                if ($sort_by == 'category_income') {
                                    echo "<th width=\"400\">Příjem</th>";
                                } else {
                                    echo "<th width=\"400\"><a href=\"index.php?action=sort&sort_by=category_income  \">Příjem</a></th>";
                                }
                                echo "<th>&nbsp;</th>";
                                echo "<th>&nbsp;</th>";
                                echo "<th>&nbsp;</th>";
                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $result = findTasksByUserId($_SESSION['user_id']);
                            while ($row = $result->fetch()) {
                                echo "<tr>";
                                if ($row['deadline'] == null) {
                                    echo "<td>&nbsp;</td>";
                                } else {
                                    echo "<td>" . date("d.m.Y", strtotime($row['deadline'])) . "</td>";
                                }
                                echo "<td><span class=\"" . getClassNameForTask($row['done']) . "\">" . $row['title'] . "</span></td>";
                                echo "<td>" . $row['category_income'] . ",- Kč" ."</td>";
                                echo "<td>";
                                if (!$row['done']) {
                                    echo " <a href=\"index.php?action=finished&task_id=" . $row['task_id'] . "\">Splněno</a>";
                                } else {
                                    echo "&nbsp;";
                                }
                                echo "</td>";
                                echo "<td><span>&nbsp;|&nbsp;</span></td>";
                                echo "<td><a href=\"index.php?action=delete&task_id=" . $row['task_id'] . "\">Odstranit</a></td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
            } else {
                notAuthorizedContent();
            }
            ?>

        </div>
    </section>

<?php
include_once 'common/footer.php';
?>
