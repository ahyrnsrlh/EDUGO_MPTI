<!-- Add Section Modal -->
<div class="modal fade" id="addSectionModal" tabindex="-1" aria-labelledby="addSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSectionModalLabel">Tambah Bagian Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addSectionForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="section_title" class="form-label">Judul Bagian <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="section_title" name="section_title" 
                               placeholder="Contoh: Pengenalan Dasar" required>
                        <small class="text-muted">Beri nama yang jelas untuk bagian ini, misalnya: "Pengenalan", "Dasar-dasar", "Praktek", dll.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah Bagian</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Section Modal -->
<div class="modal fade" id="editSectionModal" tabindex="-1" aria-labelledby="editSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSectionModalLabel">Edit Bagian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editSectionForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="editSectionId" name="section_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editSectionTitle" class="form-label">Judul Bagian <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editSectionTitle" name="section_title" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui Bagian</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Lecture Modal -->
<div class="modal fade" id="addLectureModal" tabindex="-1" aria-labelledby="addLectureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLectureModalLabel">Tambah Materi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addLectureForm">
                @csrf
                <input type="hidden" id="addLectureSectionId" name="section_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="lecture_title" class="form-label">Judul Materi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="lecture_title" name="lecture_title" 
                                       placeholder="Contoh: Pengenalan HTML" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="url" class="form-label">URL Video</label>
                                <input type="url" class="form-control" id="url" name="url" 
                                       placeholder="https://youtube.com/watch?v=...">
                                <small class="text-muted">Masukkan URL video dari YouTube, Vimeo, atau platform lainnya</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="video_duration" class="form-label">Durasi (menit)</label>
                                <input type="number" class="form-control" id="video_duration" name="video_duration" 
                                       placeholder="10" min="0" step="0.1">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Konten Materi</label>
                        <textarea class="form-control" id="content" name="content" rows="5" 
                                  placeholder="Tuliskan deskripsi, catatan, atau materi teks di sini..."></textarea>
                        <small class="text-muted">Opsional: Tambahkan catatan, transkrip, atau materi tambahan</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah Materi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Lecture Modal -->
<div class="modal fade" id="editLectureModal" tabindex="-1" aria-labelledby="editLectureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLectureModalLabel">Edit Materi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editLectureForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="editLectureId" name="lecture_id">
                <input type="hidden" id="editLectureSectionId" name="section_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="editLectureTitle" class="form-label">Judul Materi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editLectureTitle" name="lecture_title" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="editLectureUrl" class="form-label">URL Video</label>
                                <input type="url" class="form-control" id="editLectureUrl" name="url" 
                                       placeholder="https://youtube.com/watch?v=...">
                                <small class="text-muted">Masukkan URL video dari YouTube, Vimeo, atau platform lainnya</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="editLectureDuration" class="form-label">Durasi (menit)</label>
                                <input type="number" class="form-control" id="editLectureDuration" name="video_duration" 
                                       placeholder="10" min="0" step="0.1">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="editLectureContent" class="form-label">Konten Materi</label>
                        <textarea class="form-control" id="editLectureContent" name="content" rows="5" 
                                  placeholder="Tuliskan deskripsi, catatan, atau materi teks di sini..."></textarea>
                        <small class="text-muted">Opsional: Tambahkan catatan, transkrip, atau materi tambahan</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui Materi</button>
                </div>
            </form>
        </div>
    </div>
</div>
