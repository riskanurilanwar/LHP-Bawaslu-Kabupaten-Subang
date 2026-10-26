<?php

namespace App\Controllers;

use App\Models\LhpDocumentTemplateModel;

class KelolaTemplateLhp extends BaseController
{
    protected LhpDocumentTemplateModel $templateModel;

    public function __construct()
    {
        $this->templateModel = new LhpDocumentTemplateModel();
    }

    public function index()
    {
        return view('kelola_template_lhp/index', [
            'title'    => 'Template Dokumen LHP',
            'template' => $this->templateModel->getTemplate(),
            'errors'   => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function update()
    {
        $rules = [];
        $messages = [];

        foreach (LhpDocumentTemplateModel::DEFAULT_TEMPLATE as $field => $default) {
            $rules[$field] = 'required|max_length[150]';
            $messages[$field] = [
                'required'   => 'Bagian ini wajib diisi.',
                'max_length' => 'Maksimal 150 karakter.',
            ];
        }

        if (! $this->validate($rules, $messages)) {
            return redirect()->to('/kelola-template-lhp')
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $template = [];
        foreach (LhpDocumentTemplateModel::DEFAULT_TEMPLATE as $field => $default) {
            $template[$field] = trim((string) $this->request->getPost($field));
        }

        if (! $this->templateModel->saveTemplate($template)) {
            return redirect()->to('/kelola-template-lhp')
                ->withInput()
                ->with('error', 'Template dokumen gagal disimpan. Silakan coba kembali.');
        }

        return redirect()->to('/kelola-template-lhp')
            ->with('success', 'Template dokumen LHP berhasil diperbarui.');
    }
}
