<div id="form-wrapper">
    <form action="handleData.php" id="form-tag" method="post">
        <div class="field-wrapper" id="title-wrapper">
            <div class="label-wrapper">
                <p>TITLE</p>
            </div>
            <div class="input-wrapper">
                <input name="title" type="text" />
            </div>
        </div>

        <div class="field-wrapper" id="author-wrapper">
            <div class="label-wrapper">
                <p>AUTHOR</p>
            </div>
            <div class="input-wrapper">
                <input name="author" type="text" />
            </div>
        </div>

        <div class="field-wrapper" id="content-wrapper">
            <div class="label-wrapper">
                <p>CONTENT</p>
            </div>
            <div class="input-wrapper">
                <textarea name="content" type="text"></textarea>
            </div>
        </div>

        <div id="submitBtn-wrapper">
            <button  type="submit">Submit</button>
        </div>

    </form>
</div>