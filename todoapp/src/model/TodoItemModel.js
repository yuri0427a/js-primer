let toIdx = 0;
export class TodoItemModel {
    constructor({ title, completed }) {
        // idは自動的に連番となりそれぞれのインスタンスごとに異なるものとする
        this.id = todoIdx++;
        this.title = title;
        this.completed = completed;
    }
}