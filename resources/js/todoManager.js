// const { default: Echo } = require("laravel-echo")

let todoEls = document.querySelectorAll(".todo-item")
for(let todoEl of todoEls){
    const id = todoEl.getAttribute('id')
    const title = todoEl.querySelector('.container .title *')
    const status = todoEl.querySelector('.container .status *')
    const description = todoEl.querySelector('.container .description *')
    const due = todoEl.querySelector('.container .due *')

    Echo.channel(`todo.${id}.delete`)
        .listen('TodoDeletedEvent',(e)=>{
            todoEl.remove()
            console.log('remove',e)
        });

    Echo.channel(`todo.${id}.update`)
        .listen('TodoUpdatedEvent',(e)=>{
            todoEl.classList.add('edited-todo-item')
            todoEl.addEventListener("click",()=>{
                todoEl.classList.remove('edited-todo-item')
            },{once:true})
            title.innerHTML = e.todo.title
            status.innerHTML = e.todo.status
            description.innerHTML = e.todo.description
            due.innerHTML = e.todo.due
        });

}