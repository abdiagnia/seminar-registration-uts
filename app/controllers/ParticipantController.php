<?php

class ParticipantController extends Controller
{
    private Participant $model;

    public function __construct()
    {
        $this->model = new Participant();
    }

    public function index(): void
    {
        $this->requireLogin();

        $participants = $this->model->all();
        $this->view('participants/index', compact('participants'));
    }

    public function create(): void
    {
        $this->requireLogin();

        $participant = [
            'code' => '',
            'name' => '',
            'email' => '',
            'institution' => '',
            'category' => 'GENERAL',
        ];

        $errors = [];

        $this->view('participants/form', [
            'participant' => $participant,
            'errors' => $errors,
            'formAction' => '/participants/store',
            'pageTitle' => 'Tambah Peserta',
        ]);
    }

    public function store(): void
    {
        $this->requireLogin();

        [$data, $errors] = $this->validate($_POST);

        if ($errors) {
            $this->view('participants/form', [
                'participant' => $data,
                'errors' => $errors,
                'formAction' => '/participants/store',
                'pageTitle' => 'Tambah Peserta',
            ]);

            return;
        }

        try {
            $this->model->create($data);
            $_SESSION['flash'] = 'Peserta berhasil ditambahkan.';

            $this->redirect('/participants');
        } catch (PDOException $e) {
            $errors['general'] = $e->getCode() === '23000'
                ? 'Kode peserta sudah digunakan.'
                : 'Data gagal disimpan.';

            $this->view('participants/form', [
                'participant' => $data,
                'errors' => $errors,
                'formAction' => '/participants/store',
                'pageTitle' => 'Tambah Peserta',
            ]);
        }
    }

    public function edit(int $id): void
    {
        $this->requireLogin();

        $participant = $this->model->find($id);

        if (!$participant) {
            http_response_code(404);
            echo 'Peserta tidak ditemukan';
            return;
        }

        $this->view('participants/form', [
            'participant' => $participant,
            'errors' => [],
            'formAction' => '/participants/update',
            'pageTitle' => 'Ubah Peserta',
        ]);
    }

    public function update(): void
    {
        $this->requireLogin();

        $id = (int) ($_POST['id'] ?? 0);
        $old = $this->model->find($id);

        if (!$old) {
            http_response_code(404);
            echo 'Peserta tidak ditemukan';
            return;
        }

        [$data, $errors] = $this->validate($_POST);
        $data['id'] = $id;

        if ($errors) {
            $this->view('participants/form', [
                'participant' => $data,
                'errors' => $errors,
                'formAction' => '/participants/update',
                'pageTitle' => 'Ubah Peserta',
            ]);

            return;
        }

        try {
            $this->model->update($id, $data);
            $_SESSION['flash'] = 'Data peserta berhasil diubah.';

            $this->redirect('/participants');
        } catch (PDOException $e) {
            $errors['general'] = $e->getCode() === '23000'
                ? 'Kode peserta sudah digunakan.'
                : 'Data gagal diperbarui.';

            $this->view('participants/form', [
                'participant' => $data,
                'errors' => $errors,
                'formAction' => '/participants/update',
                'pageTitle' => 'Ubah Peserta',
            ]);
        }
    }

    public function destroy(): void
    {
        $this->requireLogin();

        $id = (int) ($_POST['id'] ?? 0);

        if ($id > 0) {
            $this->model->delete($id);
        }

        $_SESSION['flash'] = 'Peserta berhasil dihapus.';
        $this->redirect('/participants');
    }

    private function validate(array $input): array
    {
        $data = [
            'code' => trim($input['code'] ?? ''),
            'name' => trim($input['name'] ?? ''),
            'email' => trim($input['email'] ?? ''),
            'institution' => trim($input['institution'] ?? ''),
            'category' => strtoupper(trim($input['category'] ?? 'GENERAL')),
        ];

        $errors = [];

        foreach ([
            'code' => 'Kode peserta',
            'name' => 'Nama',
            'institution' => 'Institusi',
        ] as $key => $label) {
            if ($data[$key] === '') {
                $errors[$key] = "$label wajib diisi.";
            }
        }

        if (
            $data['email'] === ''
            || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)
        ) {
            $errors['email'] = 'Email wajib diisi dengan format yang valid.';
        }

        if (!in_array($data['category'], ['GENERAL', 'STUDENT'], true)) {
            $errors['category'] = 'Kategori hanya boleh GENERAL atau STUDENT.';
        }

        return [$data, $errors];
    }
}
