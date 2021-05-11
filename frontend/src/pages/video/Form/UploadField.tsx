// @flow 
import * as React from 'react';
import {
    Button,
    FormControl,
    FormControlProps,
} from '@material-ui/core';
import CloudUploadIcon from '@material-ui/icons/CloudUpload';
import InputFile, {InputFileComponent} from '../../../components/InputFile';

interface UploadFieldProps {
    accept: string;
    label: string;
    setValue: (value) => void;
    disabled?: boolean;
    errors?: any;
    formControlProps?: FormControlProps
};

const UploadField: React.FC<UploadFieldProps> = (props) => {
    const fileRef = React.useRef() as React.MutableRefObject<InputFileComponent>;
    const { accept, label, setValue, disabled, errors } = props;

    return (
        <FormControl
            error={errors !== undefined}
            disabled={disabled === true}
            fullWidth
            margin={'normal'}
            {...props.formControlProps}
        >
            <InputFile
                ref={fileRef}
                TextFieldProps={{
                    label: label,
                    InputLabelProps: {shrink: true},
                    style: {backgroundColor: '#ffffff'}
                }}
                InputFileProps={{
                    accept,
                    onChange(event) {
                        const files = event.target.files as any;
                        files.length && setValue(files[0]);
                    }
                }}
                ButtonFile={
                    <Button
                        endIcon={<CloudUploadIcon />}
                        variant={'contained'}
                        color={'primary'}
                        onClick={() => {
                            fileRef.current.openWindow()
                         }}
                    > Adicionar </Button>
                }
            />
        </FormControl>
    );
};

export default UploadField;