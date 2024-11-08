export default function adInserter(){
    //check if is post
    if(document.body.classList.contains('single-post')){
        console.log("post");
        const mainContainer = document.getElementById("main");
        const paragraphs = mainContainer.querySelectorAll(".post-content p");
        console.log(paragraphs);
        for (let i=0; i<paragraphs.length; i++) {
            if (i % 4 === 0){
                paragraphs[i].insertAdjacentHTML('afterend', '<p>test reklama teste tetet</p>');
            }
        }
    };

}