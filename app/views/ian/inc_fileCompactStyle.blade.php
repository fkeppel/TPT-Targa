 @foreach ($data['files']['types'] as $type)
        @foreach ($data['files']['subtypes'] as $kat)
            @if ($kat['ParentId'] == $type['Id'])
                <?php
                $cssKat = ServiceProvider::noBlanks($kat['Kategorie']);
                ?> #fileUpl{{ $cssKat }} {
                    display: none;
                }
                #dropZone{{ $cssKat }} {
                    border: 2px dashed gray;
                    border-radius: 0px;
                    width: calc(100% - 4px);
                    height: 80px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #555;
                    font-size: 16px;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    text-align: center;
                }
                /* #dropZone{{ $cssKat }}.hover {
                    background-color: #f0f0f0;
                    border-color: #333;
                }
                #dropZone{{ $cssKat }}.dragover {
                    background-color: #e0f7ff;
                    border-color: #00aaff;
                } */
                #controls{{ $cssKat }} {
                    margin-bottom: 20px;
                }
                #preview{{ $cssKat }} {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 4px;
                    overflow: auto;
                    max-height: 120px;
                }
            @endif
        @endforeach
    @endforeach