<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>Host Page</title>
    <?php $this->load->view('partials/header'); ?>
</head>

<body>
    <?php if (!empty($question)): ?>
        <textarea id="question" class="question" readonly><?= $question ?></textarea>
        <textarea id="answer" class="answer" readonly><?= $answer ?></textarea>
    <?php else: ?>
        <textarea id="question" class="question" readonly>No Question was set yet</textarea>
    <?php endif; ?>
</body>

</html>