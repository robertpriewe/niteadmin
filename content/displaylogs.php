<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Activity logs:</h4>
                <div class="mt-3">
                    <textarea rows="30" cols="50" class="form-control">
                    <?php
                    $query = mysqli_query($mysqli, 'SELECT * FROM logs ORDER BY TIMESTAMP DESC LIMIT 0, 50');
                    while($row = $query->fetch_assoc()) {
                        echo '&#13;&#10;Timestamp: ' . $row['TIMESTAMP'] . ' - User: ' . $row['USERID'] . ' - Action: ' . $row['DESCRIPTION'];
                    }
                    ?>
                        </textarea>
                </div>
            </div>
        </div>
    </div>
</div>