<?php 
    try {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (!$id === false) {
                return get_track($id);
            } else {
                return get_tracks();
            }
        } else {
            throw new Exception("Only GET methods are supported currently.");
        }
    }
    catch(Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }


    function get_track(int $id) {
        echo "I'm a track";
    }

    function get_tracks() {
        header('Content-Type: application/json');
        
        $track_files = glob ('tracks/*.[gG][pP][xX]');
        usort($track_files, function($a, $b) {
            return filemtime($a) > filemtime($b);
        });
        $response = json_encode([
            'tracks' => array_map(function($f) { 
                return 'tracks/' . rawurlencode(basename($f)); 
            }, $track_files)
        ]);
        echo $response;
    }
