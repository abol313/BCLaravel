// const { default: Echo } = require("laravel-echo")
const mainEl = document.querySelector("main")
let [fakeTodoEl,...todoEls] = Array.from(document.querySelectorAll(".todo-item"))
let noTodoEl = document.querySelector('.no-todo-item')

Echo.private('App.Models.Todo.x')
    .listen('.TodoCreated',e=>{
        console.log('Created',e)

        if(!!noTodoEl){
            noTodoEl.remove()
            noTodoEl = null
        }

        let todoEl = fakeTodoEl.cloneNode(true);
        todoEl.setAttribute("id",e.model.id)
        todoEl.removeAttribute("style")

        const titleEl = todoEl.querySelector('.container .title *')
        const statusEl = todoEl.querySelector('.container .status *')
        const descriptionEl = todoEl.querySelector('.container .description *')
        const dueEl = todoEl.querySelector('.container .due *')
        const editEl = todoEl.querySelector('.container .edit > *')
        const deleteEl = todoEl.querySelector('.container .delete > *')
        
        titleEl.innerHTML = e.model.title
        statusEl.innerHTML = e.model.status
        descriptionEl.innerHTML = e.model.description
        
        if(e.model.due===null)
            dueEl.parentElement.remove()
        else
            dueEl.innerHTML = e.model.due

        editEl.setAttribute("href",editEl.getAttribute("href").replace("-1",e.model.id))
        deleteEl.setAttribute("href",deleteEl.getAttribute("href").replace("-1",e.model.id))

        mainEl.appendChild(todoEl)

    })

for(let todoEl of todoEls){
    const id = todoEl.getAttribute('id')
    const title = todoEl.querySelector('.container .title *')
    const status = todoEl.querySelector('.container .status *')
    const description = todoEl.querySelector('.container .description *')
    const due = todoEl.querySelector('.container .due *') || fakeTodoEl.cloneNode(true).querySelector('.container .due *')

    Echo.private('App.Models.Todo.'+id)
        .listen('.TodoSaved',e=>console.log('Saved',e))
        .listen('.TodoUpdated',e=>{
            console.log('Updated',e)
            todoEl.classList.add('edited-todo-item')
            todoEl.addEventListener("click",()=>{
                todoEl.classList.remove('edited-todo-item')
            },{once:true})
            title.innerHTML = e.model.title
            status.innerHTML = e.model.status
            description.innerHTML = e.model.description
            due && (due.innerHTML = e.model.due);
            // if(e.model.due){
            //     due.innerHTML = e.model.due
            //     if(due)
            //         todoEl.appendChild(due)
            // }
        })
        .listen('.TodoDeleted',e=>{
            console.log('Deleted',e)
            todoEl.remove()
        })
        .listen('.TodoTrashed',e=>console.log('Trashed',e))
        .listen('.TodoRestored',e=>console.log('Restored',e))

}

