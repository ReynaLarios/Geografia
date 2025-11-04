class InsertBoxPlugin {
    constructor(editor) {
        this.editor = editor;
    }

    init() {
        const editor = this.editor;

        editor.ui.componentFactory.add('insertBox', locale => {
            const view = new editor.ui.button.ButtonView(locale);

            view.set({
                label: 'Insertar cuadro informativo',
                tooltip: true,
                withText: true
            });

            view.on('execute', () => {
                const html = `
<div style="border:2px solid #007bff;padding:10px;border-radius:6px;background-color:#f0f8ff;margin:10px 0;">
    <strong>Título:</strong> <em>Escribe aquí el título...</em><br>
    <strong>Autor:</strong> <em>Nombre del autor...</em><br>
    <a href="#" target="_blank">Descargar documento</a>
</div><br>`;

                editor.model.change(writer => {
                    const viewFragment = editor.data.processor.toView(html);
                    const modelFragment = editor.data.toModel(viewFragment);
                    editor.model.insertContent(modelFragment, editor.model.document.selection);
                });
            });

            return view;
        });
    }
}

export default InsertBoxPlugin;
