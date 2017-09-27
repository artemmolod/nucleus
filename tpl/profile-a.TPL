<div id="ajax_page">
    {block-user}
    <div class="profile">
        <div class="new-profile-block new-profile-bg">
            <div class="profile-cover new-profile-cover">
                <div class="profile-image-block new-profile-bg_image" style="background-image: url({photo_src})" id="profile_photo">
                   <div class="profile-image"></div>
                </div>
            </div> 
            <div class="profile-name-block new-profile-name_block">
               <div class="profile-name">
                   {name} 
                   {user-ver}
               </div>
            </div>
        </div>
        {profile-content}
     </div>
     <div class="pad10"></div>
</div>