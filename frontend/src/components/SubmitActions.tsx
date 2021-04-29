// @flow 
import { Box, Button, ButtonProps, makeStyles, Theme } from '@material-ui/core';
import * as React from 'react';

const useStyles = makeStyles((theme: Theme) => {
    return {
        submit: {
            margin: theme.spacing(1)
        }
    }
})

interface SubmitActionsProps {
    disabledButtons?: boolean;
    handleSave: () => void;
}
const SubmitActions: React.FC<SubmitActionsProps> = (props) => {
    
    const classes = useStyles();
    const buttonProps: ButtonProps = {
        variant: 'contained',
        color: 'secondary',
        size: 'medium',
        className: classes.submit,
        disabled: props.disabledButtons === undefined ? false: props.disabledButtons
    }
    
    return (
        <Box>
            <Button {...buttonProps} onClick={props.handleSave}>Salvar</Button>
            <Button {...buttonProps} type="submit">Salvar e continuar editando</Button>
        </Box>
    );
};

export default SubmitActions;