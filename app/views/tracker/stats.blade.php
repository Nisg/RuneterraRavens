<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    th,td {
        padding: 15px;
    }
</style>

<table>
    <tr>
        <th>Data</th>
        <th>Average last 20 matches</th>
        <th>Last game</th>
        <th>Difference</th>
    </tr>
    <?php
    foreach ($avg_stats as $key => $value) {
        echo ("<tr>");
        echo ("<td> $key </td>");
        echo ("<td> $value </td>");
        echo ("<td> $new_stats[$key] </td>");
        echo ("<td> " . ($new_stats[$key] - $value) . " </td>");
        echo ("</tr>");
    }
    ?>

</table>
