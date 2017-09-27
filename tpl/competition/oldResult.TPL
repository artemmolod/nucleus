<style>
   @import url(/tpl/css/intro.css?v=48);
</style>
[none]
<div class="intro-main">
    <div class="intro-container">
        <div class="intro-step-container">
            <div class="intro-step">
                <div class="step-image" onclick="">
                    <img src="{src}" class="step-img-p">
                </div>
                <div class="step-title">
                    <div class="st-header">Результат прошлого конкурса</div>
                    <div class="st-title">
                        В прошлом конкурсе, к сожалению, никто участие не принял.
                        <div class="st-btn">
                            <button class="st-button" onclick="competition.closeOldResult()">Закрыть</button>
                        </div>
                    </div>
                </div>
             </div>
         </div>
    </div>
</div>
[/none]

[one]
<div class="intro-main">
    <div class="intro-container">
        <div class="intro-step-container">
            <div class="intro-step">
                <div class="step-image" onclick="">
                    <img src="{src}" class="step-img-p">
                </div>
                <div class="step-title">
                    <div class="st-header">Результат прошлого конкурса</div>
                    <div class="st-title">
                        Победителем стал - <a href="/id{wid}" target="_blank">{king-name}</a>, чья фотография набрала {rating-king-photo} б. рейтинга.
                        <div class="st-btn">
                            <button class="st-button" onclick="competition.closeOldResult()">Закрыть</button>
                        </div>
                    </div>
                </div>
             </div>
         </div>
    </div>
</div>
[/one]

[two]
<div class="intro-main">
    <div class="intro-container">
        <div class="intro-step-container">
            <div class="intro-step">
                <div class="step-image" onclick="">
                    <img src="{src}" class="step-img-p">
                </div>
                <div class="step-title">
                    <div class="st-header">Результат прошлого конкурса</div>
                    <div class="st-title">
                        Победителем стал - <a href="/id{wid}" target="_blank">{king-name}</a>, чья фотография набрала {rating-king-photo} б. рейтинга.
                        Второе место занял  <a href="/id{twoid}" target="_blank">{place-two-name}</a>.
                        <div class="st-btn">
                            <button class="st-button" onclick="competition.closeOldResult()">Закрыть</button>
                        </div>
                    </div>
                </div>
             </div>
         </div>
    </div>
</div>
[/two]

[three]
<div class="intro-main">
    <div class="intro-container">
        <div class="intro-step-container">
            <div class="intro-step">
                <div class="step-image" onclick="">
                    <img src="{src}" class="step-img-p">
                </div>
                <div class="step-title">
                    <div class="st-header">Результат прошлого конкурса</div>
                    <div class="st-title">
                        Победителем стал - <a href="/id{wid}" target="_blank">{king-name}</a>, чья фотография набрала {rating-king-photo} б. рейтинга.
                        Второе и третье место заняли  <a href="/id{twoid}" target="_blank">{place-two-name}</a> и  <a href="/id{threeid}" target="_blank">{place-three-name}</a> соответственно.
                        <div class="st-btn">
                            <button class="st-button" onclick="competition.closeOldResult()">Закрыть</button>
                        </div>
                    </div>
                </div>
             </div>
         </div>
    </div>
</div>
[/three]