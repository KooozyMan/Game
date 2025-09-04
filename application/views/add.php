<!DOCTYPE htlml>
<html>

<head>
    <meta charset="UTF-8">
    <title>حروف وألوف</title>
    <?php $this->load->view('partials/header'); ?>
</head>

<body>

    <?php if (!empty($confirmation)): ?>
        <div class="confirmation <?= $confirmation_type ?>"><?= $confirmation ?></div>
    <?php endif; ?>
    <form id="add_question" method="post" action="<?= site_url('Add/addQuestion') ?>">

        <div class="form-group">
            <label for="question">السؤال</label>
            <textarea type="text" name="question" id="question" rows="1"
                oninput="this.style.height='';this.style.height=this.scrollHeight+'px'"></textarea>
        </div>

        <div class="form-group">
            <label for="answer">الجواب</label>
            <input type="text" name="answer" id="answer">
        </div>

        <div class="form-group">
            <label>نوع السؤال
                <?php if (!empty($types)): ?>
                    <select name="type_id" id="type_id">
                        <option value="" class="select-items">-- Select --</option>

                        <?php foreach ($types as $t): ?>
                            <option value="<?= htmlspecialchars($t['type_id']) ?>" class="select-items">
                                <?= htmlspecialchars($t['type']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <p>no types were found please add a type</p>
                <?php endif; ?>
            </label>
        </div>

        <div class="form-group">
            <label>الحرف
                <select name="letter_id" id="letter_id">
                    <option value="" class="select-items">-- Select --</option>

                    <?php foreach ($letters as $l): ?>
                        <option value="<?= htmlspecialchars($l['id']) ?>" class="select-items fontsize">
                            <?= htmlspecialchars($l['letter']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <button type="submit" id="addQbtn">Submit</button>
    </form>

    <form id="add_type" method="post" action="<?= site_url('Add/addType') ?>">
        <div class="form-group">
            <label for="type">النوع</label>
            <input name="type" id="type" type="text">
        </div>

        <button type="submit" id="addQbtn">Submit</button>
    </form>

</body>
<script>
    const confirmation = document.querySelector('.confirmation');
    if (confirmation) {
        setTimeout(() => {
            confirmation.classList.add('hide');
        }, 3000);
    }
</script>