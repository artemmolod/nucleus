<div id="ajax_page">
    <div class="lenta-list-container">
        <div class="lenta-list-header">
            <div class="fll lenta-list-photo_user" style="background-image: url({photo-user})"></div>
            <div class="fll lenta-list-name_user">
                <div><a href="/photo/{uid}" onclick="ajax.page(this.href);">{name-user}</a></div>
                <div>{last-date-upload-photo}</div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="lenta-list-content">
            <div class="lenta-sc">{photo-user-list}</div>
        </div>
    </div>
</div>
{lenta-container}