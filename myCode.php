<?php
 public function Apiuploadberkas(){
        header('Content-Type: application/json');
        $data = $this->verifyToken();
        $config['upload_path'] = './file/berkasproposal/';
        $config['allowed_types'] = 'pdf';
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);
        if(!empty($_FILES['fileupload']['name'])){
             if ($this->upload->do_upload('fileupload')){
                 $nama = $this->upload->data();
                 $filenameberkas= 'file/berkasproposal/'.$nama['file_name'];
                 //hapus berkas lama
                 $berkas = $this->Mproposal->berkaskatproposal($data->id,$this->input->post('id_katproposal'));
                 if($berkas->num_rows()){
                    $ber= $berkas->row_array();
                    @unlink($ber['file_berkasproposal']);
                    $this->db->where('id_berkasproposal',$ber['id_berkasproposal']);
                    $this->db->delete('berkasproposal');
                }
                $this->Mproposal->uploadberkas($data->id,$filenameberkas);
                echo json_encode([
                    'status' => true,
                    'msg' => 'File Proposal Berhasil Di Upload'
                ]);
             }
             else{
                 echo json_encode([
                    'status' => false,
                    'msg' => 'Periksa Kembali File Berkas Minimal *PDF'
                 ]);
                 
             }
        }
        else{
            echo json_encode([
                'status' => false,
                'msg' => 'Form tidak boleh kosong'
             ]);
        }
	}

?>
