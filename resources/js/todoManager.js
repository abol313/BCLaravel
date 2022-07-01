// const { default: Echo } = require("laravel-echo")
const mainEl = document.querySelector("main")
let [fakeTodoEl,...todoEls] = Array.from(document.querySelectorAll(".todo-item"))
let noTodoEl = document.querySelector('.no-todo-item')

Echo.channel('todo.new')
    .listen('TodoCreatedEvent', e=>{
        // console.log(e);

        if(!!noTodoEl){
            noTodoEl.remove()
            noTodoEl = null
        }

        debugger;
        let todoEl = fakeTodoEl.cloneNode(true);
        todoEl.setAttribute("id",e.todo.id)
        todoEl.removeAttribute("style")

        const titleEl = todoEl.querySelector('.container .title *')
        const statusEl = todoEl.querySelector('.container .status *')
        const descriptionEl = todoEl.querySelector('.container .description *')
        const dueEl = todoEl.querySelector('.container .due *')
        const editEl = todoEl.querySelector('.container .edit > *')
        const deleteEl = todoEl.querySelector('.container .delete > *')
        
        titleEl.innerHTML = e.todo.title
        statusEl.innerHTML = e.todo.status
        descriptionEl.innerHTML = e.todo.description
        
        if(e.todo.due===null)
            dueEl.parentElement.remove()
        else
            dueEl.innerHTML = e.todo.due

        editEl.setAttribute("href",editEl.getAttribute("href").replace("-1",e.todo.id))
        deleteEl.setAttribute("href",deleteEl.getAttribute("href").replace("-1",e.todo.id))

        mainEl.appendChild(todoEl)
    })
for(let todoEl of todoEls){
    const id = todoEl.getAttribute('id')
    const title = todoEl.querySelector('.container .title *')
    const status = todoEl.querySelector('.container .status *')
    const description = todoEl.querySelector('.container .description *')
    const due = todoEl.querySelector('.container .due *')

    Echo.channel(`todo.${id}`)
        .listen('TodoDeletedEvent', e=>{
            todoEl.remove()
            console.log('remove',e)
        })
        .listen('TodoUpdatedEvent', e=>{
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

