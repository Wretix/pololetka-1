<?php
include 'lib/db.php';
include 'lib/common.php';
include_once 'common/header.php';
function isNotEmpty ($income) {
    return isset($income);
}
if (!empty($_POST['issubmit'])) {
    if (isNotEmpty($_POST['income'])) {
        if (is_numeric($_POST['income'])) {
            $create = createCategory($_POST['income'], $_SESSION['user_id']);
            if ($create) {
                header("Location: settings.php");
            }
        } else {
            writeErrorMessage('Příjem je ve špatném formátu');
        }
    }
}
?>

<div class="main-container">
    <div class="main-wrapper">
        <h2>Nastavení</h2>
        <h3>Příjmy</h3>
        <form class="form" action="settings.php" method="POST">
            <input type="text" title="Zadejte částku příjmu" name="income"
                   placeholder="Zadejte částku příjmu v kč" required>
            <input type="hidden" name="issubmit" value="true">
            <button type="submit" name="submit">Přidat částku</button>
        </form>
        <div class="settings">
        <table>
            <thead>
            <tr>
                <th>Všechny možné částky</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $category = findCategories($_SESSION['user_id']);
            while ($row = $category->fetch()) {
                echo '<tr>';
                 echo "<td>" . $row['income'] . ",- Kč" . "</td>";
                echo '</tr>';
            }
            ?>
            </tbody>

        </table>
        </div>
    </div>
</div>



<?php
include_once 'common/footer.php';
?>
